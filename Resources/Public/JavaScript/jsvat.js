var jsvat = (function() {
	'use strict'
	function Result(vat, isValid, country) {
		this.value = vat || null
		this.isValid = !!isValid
		if (country) {
			this.country = {
				name: country.name,
				isoCode: {
					short: country.codes[0],
					long: country.codes[1],
					numeric: country.codes[2]
				}
			}
		}
	}
	function removeExtraChars(vat) {
		vat = vat || ''
		return vat.toString().toUpperCase().replace(/(\s|-|\.)+/g, '')
	}
	function isValEqToCode(val, codes) {
		return (val === codes[0] || val === codes[1] || val === codes[2])
	}
	function isInList(list, country) {
		if (!list) return false
		for (var i = 0; i < list.length; i++) {
			var val = list[i].toUpperCase()
			if (val === country.name.toUpperCase()) return true
			if (isValEqToCode(val, country.codes)) return true
		}
		return false
	}
	function isBlocked(country, blocked, allowed) {
		var isBlocked = isInList(blocked, country)
		if (isBlocked) return true
		var isAllowed = isInList(allowed, country)
		return allowed.length > 0 && !isAllowed
	}
	function getCountry(vat, countries) {
		for (var k in countries) {
			if (countries.hasOwnProperty(k)) {
				var regexpValidRes = isVatValidToRegexp(vat, countries[k].rules.regex)
				if (regexpValidRes.isValid) return countries[k]
			}
		}
		return null
	}
	function isVatValidToRegexp(vat, regexArr) {
		for (var i = 0; i < regexArr.length; i++) {
			var regex = regexArr[i]
			var isValid = regex.test(vat)
			if (isValid) return {
				isValid: true,
				regex: regex
			}
		}
		return {
			isValid: false
		}
	}
	function isVatMathValid(vat, country) {
		return country.calcFn(vat)
	}
	function isVatValid(vat, country) {
		var regexpValidRes = isVatValidToRegexp(vat, country.rules.regex)
		if (!regexpValidRes.isValid) return false
		return isVatMathValid(regexpValidRes.regex.exec(vat)[2], country)
	}
	var exports = {
		blocked: [],
		allowed: [],
		countries: {},
		checkVAT: function(vat) {
			if (!vat) throw new Error('VAT should be specified')
			var cleanVAT = removeExtraChars(vat)
			var result = new Result(cleanVAT)
			var country = getCountry(cleanVAT, this.countries)
			if (!country) return result
			if (isBlocked(country, this.blocked, this.allowed)) return new Result(cleanVAT, false, country)
			var isValid = isVatValid(cleanVAT, country)
			if (isValid) return new Result(cleanVAT, isValid, country)
			return result
		}
	}
	exports.countries.austria = {
		name: 'Austria',
		codes: ['AT', 'AUT', '040'],
		calcFn: function(vat) {
			var total = 0
			var temp
			for (var i = 0; i < 7; i++) {
				temp = vat.charAt(i) * this.rules.multipliers[i]
				if (temp > 9) {
					total += Math.floor(temp / 10) + temp % 10
				} else {
					total += temp
				}
			}
			total = 10 - (total + 4) % 10
			if (total === 10) total = 0
			return total === +vat.slice(7, 8)
		},
		rules: {
			multipliers: [1, 2, 1, 2, 1, 2, 1],
			regex: [/^(AT)U(\d{8})$/]
		}
	}
	exports.countries.belgium = {
		name: 'Belgium',
		codes: ['BE', 'BEL', '056'],
		calcFn: function(vat) {
			if (vat.length === 9) {
				vat = '0' + vat
			}
			if (+vat.slice(1, 2) === 0) return false
			var check = (97 - +vat.slice(0, 8) % 97)
			return check === +vat.slice(8, 10)
		},
		rules: {
			regex: [/^(BE)(0?\d{9})$/]
		}
	}
	exports.countries.bulgaria = {
		name: 'Bulgaria',
		codes: ['BG', 'BGR', '100'],
		calcFn: function(vat) {
			function _increase(value, vat, from, to, incr) {
				for (var i = from; i < to; i++) {
					value += +vat.charAt(i) * (i + incr)
				}
				return value
			}
			function _increase2(value, vat, from, to, multipliers) {
				for (var i = from; i < to; i++) {
					value += +vat.charAt(i) * multipliers[i]
				}
				return value
			}
			function _checkNineLengthVat(vat) {
				var total
				var temp = 0
				var expect = +vat.slice(8)
				temp = _increase(temp, vat, 0, 8, 1)
				total = temp % 11
				if (total !== 10) {
					return total === expect
				}
				temp = _increase(0, vat, 0, 8, 3)
				total = temp % 11
				if (total === 10) total = 0
				return total === expect
			}
			function _isPhysicalPerson(vat, rules) {
				if ((/^\d\d[0-5]\d[0-3]\d\d{4}$/).test(vat)) {
					var month = +vat.slice(2, 4)
					if ((month > 0 && month < 13) || (month > 20 && month < 33) || (month > 40 && month < 53)) {
						var total = _increase2(0, vat, 0, 9, rules.multipliers.physical)
						total = total % 11
						if (total === 10) total = 0
						if (total === +vat.substr(9, 1)) return true
					}
				}
				return false
			}
			function _isForeigner(vat, rules) {
				var total = _increase2(0, vat, 0, 9, rules.multipliers.foreigner)
				if (total % 10 === +vat.substr(9, 1)) {
					return true
				}
			}
			function _miscellaneousVAT(vat, rules) {
				var total = _increase2(0, vat, 0, 9, rules.multipliers.miscellaneous)
				total = 11 - total % 11
				if (total === 10) return false
				if (total === 11) total = 0
				var expect = +vat.substr(9, 1)
				return total === expect
			}
			if (vat.length === 9) {
				return _checkNineLengthVat(vat)
			} else {
				return _isPhysicalPerson(vat, this.rules) || _isForeigner(vat, this.rules) || _miscellaneousVAT(vat, this.rules)
			}
		},
		rules: {
			multipliers: {
				physical: [2, 4, 8, 5, 10, 9, 7, 3, 6],
				foreigner: [21, 19, 17, 13, 11, 9, 7, 3, 1],
				miscellaneous: [4, 3, 2, 7, 6, 5, 4, 3, 2]
			},
			regex: [/^(BG)(\d{9,10})$/]
		}
	}
	exports.countries.croatia = {
		name: 'Croatia',
		codes: ['HR', 'HRV', '191'],
		calcFn: function(vat) {
			var expect
			var product = 10
			var sum = 0
			for (var i = 0; i < 10; i++) {
				sum = (+vat.charAt(i) + product) % 10
				if (sum === 0) {
					sum = 10
				}
				product = (2 * sum) % 11
			}
			expect = +vat.slice(10, 11)
			return (product + expect) % 10 === 1
		},
		rules: {
			regex: [/^(HR)(\d{11})$/]
		}
	}
	exports.countries.cyprus = {
		name: 'Cyprus',
		codes: ['CY', 'CYP', '196'],
		calcFn: function(vat) {
			var total = 0
			var expect
			if (+vat.slice(0, 2) === 12) return false
			for (var i = 0; i < 8; i++) {
				var temp = +vat.charAt(i)
				if (i % 2 === 0) {
					switch (temp) {
						case 0:
							temp = 1
							break
						case 1:
							temp = 0
							break
						case 2:
							temp = 5
							break
						case 3:
							temp = 7
							break
						case 4:
							temp = 9
							break
						default:
							temp = temp * 2 + 3
					}
				}
				total += temp
			}
			total = total % 26
			total = String.fromCharCode(total + 65)
			expect = vat.substr(8, 1)
			return total === expect
		},
		rules: {
			regex: [/^(CY)([0-59]\d{7}[A-Z])$/]
		}
	}
	exports.countries.czech_republic = {
		name: 'Czech Republic',
		codes: ['CZ', 'CZE', '203'],
		calcFn: function(vat) {
			function _isLegalEntities(vat, rules) {
				var total = 0
				if (rules.additional[0].test(vat)) {
					for (var i = 0; i < 7; i++) {
						total += +vat.charAt(i) * rules.multipliers[i]
					}
					total = 11 - total % 11
					if (total === 10) total = 0
					if (total === 11) total = 1
					var expect = +vat.slice(7, 8)
					return total === expect
				}
				return false
			}
			function _isIndividualType1(vat, rules) {
				if (rules.additional[1].test(vat)) {
					var temp = +vat.slice(0, 2)
					if (temp > 62) {
						return false
					} else {
						return true
					}
				}
			}
			function _isIndividualType2(vat, rules) {
				var total = 0
				if (rules.additional[2].test(vat)) {
					for (var j = 0; j < 7; j++) {
						total += +vat.charAt(j + 1) * rules.multipliers[j]
					}
					total = 11 - total % 11
					if (total === 10) total = 0
					if (total === 11) total = 1
					var expect = +vat.slice(8, 9)
					return rules.lookup[total - 1] === expect
				}
				return false
			}
			function _isIndividualType3(vat, rules) {
				if (rules.additional[3].test(vat)) {
					var temp = +vat.slice(0, 2) + vat.slice(2, 4) + vat.slice(4, 6) + vat.slice(6, 8) + vat.slice(8)
					var expect = +vat % 11 === 0
					return !!(temp % 11 === 0 && expect)
				}
				return false
			}
			if (_isLegalEntities(vat, this.rules)) return true
			if (_isIndividualType2(vat, this.rules)) return true
			if (_isIndividualType3(vat, this.rules)) return true
			if (_isIndividualType1(vat, this.rules)) return true
			return false
		},
		rules: {
			multipliers: [8, 7, 6, 5, 4, 3, 2],
			lookup: [8, 7, 6, 5, 4, 3, 2, 1, 0, 9, 10],
			regex: [/^(CZ)(\d{8,10})(\d{3})?$/],
			additional: [
				/^\d{8}$/,
				/^[0-5][0-9][0|1|5|6]\d[0-3]\d\d{3}$/,
				/^6\d{8}$/,
				/^\d{2}[0-3|5-8]\d[0-3]\d\d{4}$/
			]
		}
	}
	exports.countries.denmark = {
		name: 'Denmark',
		codes: ['DK', 'DNK', '208'],
		calcFn: function(vat) {
			var total = 0
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			return total % 11 === 0
		},
		rules: {
			multipliers: [2, 7, 6, 5, 4, 3, 2, 1],
			regex: [/^(DK)(\d{8})$/]
		}
	}
	exports.countries.estonia = {
		name: 'Estonia',
		codes: ['EE', 'EST', '233'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 10 - total % 10
			if (total === 10) total = 0
			expect = +vat.slice(8, 9)
			return total === expect
		},
		rules: {
			multipliers: [3, 7, 1, 3, 7, 1, 3, 7],
			regex: [/^(EE)(10\d{7})$/]
		}
	}
	exports.countries.europe = {
		name: 'Europe',
		codes: ['EU', 'EUR', '000'],
		calcFn: function() {
			return true
		},
		rules: {
			regex: [/^(EU)(\d{9})$/]
		}
	}
	exports.countries.finland = {
		name: 'Finland',
		codes: ['FI', 'FIN', '246'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 7; i++) total += +vat.charAt(i) * this.rules.multipliers[i]
			total = 11 - total % 11
			if (total > 9) {
				total = 0
			}
			expect = +vat.slice(7, 8)
			return total === expect
		},
		rules: {
			multipliers: [7, 9, 10, 5, 8, 4, 2],
			regex: [/^(FI)(\d{8})$/]
		}
	}
	exports.countries.france = {
		name: 'France',
		codes: ['FR', 'FRA', '250'],
		calcFn: function(vat) {
			var total
			var expect
			if (!(/^\d{11}$/).test(vat)) {
				return true
			}
			total = +vat.substring(2)
			total = (total * 100 + 12) % 97
			expect = +vat.slice(0, 2)
			return total === expect
		},
		rules: {
			regex: [
				/^(FR)(\d{11})$/,
				/^(FR)([A-HJ-NP-Z]\d{10})$/,
				/^(FR)(\d[A-HJ-NP-Z]\d{9})$/,
				/^(FR)([A-HJ-NP-Z]{2}\d{9})$/
			]
		}
	}
	exports.countries.germany = {
		name: 'Germany',
		codes: ['DE', 'DEU', '276'],
		calcFn: function(vat) {
			var product = 10
			var sum = 0
			var checkDigit = 0
			var expect
			for (var i = 0; i < 8; i++) {
				sum = (+vat.charAt(i) + product) % 10
				if (sum === 0) {
					sum = 10
				}
				product = (2 * sum) % 11
			}
			if (11 - product === 10) {
				checkDigit = 0
			} else {
				checkDigit = 11 - product
			}
			expect = +vat.slice(8, 9)
			return checkDigit === expect
		},
		rules: {
			regex: [/^(DE)([1-9]\d{8})$/]
		}
	}
	exports.countries.greece = {
		name: 'Greece',
		codes: ['GR', 'GRC', '300'],
		calcFn: function(vat) {
			var total = 0
			var expect
			if (vat.length === 8) {
				vat = '0' + vat
			}
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = total % 11
			if (total > 9) {
				total = 0
			}
			expect = +vat.slice(8, 9)
			return total === expect
		},
		rules: {
			multipliers: [
				256,
				128,
				64,
				32,
				16,
				8,
				4,
				2
			],
			regex: [/^(EL)(\d{9})$/]
		}
	}
	exports.countries.hungary = {
		name: 'Hungary',
		codes: ['HU', 'HUN', '348'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 7; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 10 - total % 10
			if (total === 10) total = 0
			expect = +vat.slice(7, 8)
			return total === expect
		},
		rules: {
			multipliers: [
				9,
				7,
				3,
				1,
				9,
				7,
				3
			],
			regex: [/^(HU)(\d{8})$/]
		}
	}
	exports.countries.ireland = {
		name: 'Ireland',
		codes: ['IE', 'IRL', '372'],
		calcFn: function(vat) {
			var total = 0
			var expect
			if (this.rules.typeFormats.first.test(vat)) {
				vat = '0' + vat.substring(2, 7) + vat.substring(0, 1) + vat.substring(7, 8)
			}
			for (var i = 0; i < 7; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			if (this.rules.typeFormats.third.test(vat)) {
				if (vat.charAt(8) === 'H') {
					total += 72
				} else {
					total += 9
				}
			}
			total = total % 23
			if (total === 0) {
				total = 'W'
			} else {
				total = String.fromCharCode(total + 64)
			}
			expect = vat.slice(7, 8)
			return total === expect
		},
		rules: {
			multipliers: [8, 7, 6, 5, 4, 3, 2],
			typeFormats: {
				first: /^\d[A-Z*+]/,
				third: /^\d{7}[A-Z][AH]$/
			},
			regex: [
				/^(IE)(\d{7}[A-W])$/,
				/^(IE)([7-9][A-Z*+)]\d{5}[A-W])$/,
				/^(IE)(\d{7}[A-W][AH])$/
			]
		}
	}
	exports.countries.italy = {
		name: 'Italy',
		codes: ['IT', 'ITA', '380'],
		calcFn: function(vat) {
			var total = 0
			var temp
			var expect
			if (+vat.slice(0, 7) === 0) {
				return false
			}
			temp = +vat.slice(7, 10)
			if ((temp < 1) || (temp > 201) && temp !== 999 && temp !== 888) {
				return false
			}
			for (var i = 0; i < 10; i++) {
				temp = +vat.charAt(i) * this.rules.multipliers[i]
				if (temp > 9)
					total += Math.floor(temp / 10) + temp % 10
				else
					total += temp
			}
			total = 10 - total % 10
			if (total > 9) {
				total = 0
			}
			expect = +vat.slice(10, 11)
			return total === expect
		},
		rules: {
			multipliers: [1, 2, 1, 2, 1, 2, 1, 2, 1, 2],
			regex: [/^(IT)(\d{11})$/]
		}
	}
	exports.countries.latvia = {
		name: 'Latvia',
		codes: ['LV', 'LVA', '428'],
		calcFn: function(vat) {
			var total = 0
			var expect
			if ((/^[0-3]/).test(vat)) {
				return !!(/^[0-3][0-9][0-1][0-9]/).test(vat)
			} else {
				for (var i = 0; i < 10; i++) {
					total += +vat.charAt(i) * this.rules.multipliers[i]
				}
				if (total % 11 === 4 && vat[0] === 9) total = total - 45
				if (total % 11 === 4) {
					total = 4 - total % 11
				} else if (total % 11 > 4) {
					total = 14 - total % 11
				} else if (total % 11 < 4) {
					total = 3 - total % 11
				}
				expect = +vat.slice(10, 11)
				return total === expect
			}
		},
		rules: {
			multipliers: [9, 1, 4, 8, 3, 10, 2, 5, 7, 6],
			regex: [/^(LV)(\d{11})$/]
		}
	}
	exports.countries.lithuania = {
		name: 'Lithuania',
		codes: ['LT', 'LTU', '440'],
		calcFn: function(vat) {
			function _extractDigit(vat, multiplier, key) {
				return +vat.charAt(key) * multiplier[key]
			}
			function _doubleCheckCalculation(vat, total, rules) {
				if (total % 11 === 10) {
					total = 0
					for (var i = 0; i < 8; i++) {
						total += _extractDigit(vat, rules.multipliers.short, i)
					}
				}
				return total
			}
			function extractDigit(vat, total) {
				for (var i = 0; i < 8; i++) {
					total += +vat.charAt(i) * (i + 1)
				}
				return total
			}
			function checkDigit(total) {
				total = total % 11
				if (total === 10) {
					total = 0
				}
				return total
			}
			function _check9DigitVat(vat, rules) {
				var total = 0
				if (vat.length === 9) {
					if (!(/^\d{7}1/).test(vat)) return false
					total = extractDigit(vat, total)
					total = _doubleCheckCalculation(vat, total, rules)
					total = checkDigit(total)
					var expect = +vat.slice(8, 9)
					return total === expect
				}
				return false
			}
			function extractDigit12(vat, total, rules) {
				for (var k = 0; k < 11; k++) {
					total += _extractDigit(vat, rules.multipliers.med, k)
				}
				return total
			}
			function _doubleCheckCalculation12(vat, total, rules) {
				if (total % 11 === 10) {
					total = 0
					for (var l = 0; l < 11; l++) {
						total += _extractDigit(vat, rules.multipliers.alt, l)
					}
				}
				return total
			}
			function _check12DigitVat(vat, rules) {
				var total = 0
				if (vat.length === 12) {
					if (!(rules.check).test(vat)) return false
					total = extractDigit12(vat, total, rules)
					total = _doubleCheckCalculation12(vat, total, rules)
					total = checkDigit(total)
					var expect = +vat.slice(11, 12)
					return total === expect
				}
				return false
			}
			return _check9DigitVat(vat, this.rules) || _check12DigitVat(vat, this.rules)
		},
		rules: {
			multipliers: {
				short: [3, 4, 5, 6, 7, 8, 9, 1],
				med: [1, 2, 3, 4, 5, 6, 7, 8, 9, 1, 2],
				alt: [3, 4, 5, 6, 7, 8, 9, 1, 2, 3, 4]
			},
			check: /^\d{10}1/,
			regex: [/^(LT)(\d{9}|\d{12})$/]
		}
	}
	exports.countries.luxembourg = {
		name: 'Luxembourg',
		codes: ['LU', 'LUX', '442'],
		calcFn: function(vat) {
			var expect = +vat.slice(6, 8)
			var checkDigit = +vat.slice(0, 6) % 89
			return checkDigit === expect
		},
		rules: {
			regex: [/^(LU)(\d{8})$/]
		}
	}
	exports.countries.malta = {
		name: 'Malta',
		codes: ['MT', 'MLT', '470'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 6; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 37 - total % 37
			expect = +vat.slice(6, 8)
			return total === expect
		},
		rules: {
			multipliers: [3, 4, 6, 7, 8, 9],
			regex: [/^(MT)([1-9]\d{7})$/]
		}
	}
	exports.countries.netherlands = {
		name: 'Netherlands',
		codes: ['NL', 'NLD', '528'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = total % 11
			if (total > 9) {
				total = 0
			}
			expect = +vat.slice(8, 9)
			return total === expect
		},
		rules: {
			multipliers: [9, 8, 7, 6, 5, 4, 3, 2],
			regex: [/^(NL)(\d{9})B\d{2}$/]
		}
	}
	exports.countries.norway = {
		name: 'Norway',
		codes: ['NO', 'NOR', '578'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 11 - total % 11
			if (total === 11) {
				total = 0
			}
			if (total < 10) {
				expect = +vat.slice(8, 9)
				return total === expect
			}
		},
		rules: {
			multipliers: [3, 2, 7, 6, 5, 4, 3, 2],
			regex: [/^(NO)(\d{9})$/]
		}
	}
	exports.countries.poland = {
		name: 'Poland',
		codes: ['PL', 'POL', '616'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 9; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = total % 11
			if (total > 9) {
				total = 0
			}
			expect = +vat.slice(9, 10)
			return total === expect
		},
		rules: {
			multipliers: [6, 5, 7, 2, 3, 4, 5, 6, 7],
			regex: [/^(PL)(\d{10})$/]
		}
	}
	exports.countries.portugal = {
		name: 'Portugal',
		codes: ['PT', 'PRT', '620'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 11 - total % 11
			if (total > 9) {
				total = 0
			}
			expect = +vat.slice(8, 9)
			return total === expect
		},
		rules: {
			multipliers: [9, 8, 7, 6, 5, 4, 3, 2],
			regex: [/^(PT)(\d{9})$/]
		}
	}
	exports.countries.romania = {
		name: 'Romania',
		codes: ['RO', 'ROU', '642'],
		calcFn: function(vat) {
			var total = 0
			var expect
			var vatLength = vat.length
			var multipliers = this.rules.multipliers.slice(10 - vatLength)
			for (var i = 0; i < vat.length - 1; i++) {
				total += +vat.charAt(i) * multipliers[i]
			}
			total = (10 * total) % 11
			if (total === 10) total = 0
			expect = +vat.slice(vat.length - 1, vat.length)
			return total === expect
		},
		rules: {
			multipliers: [7, 5, 3, 2, 1, 7, 5, 3, 2],
			regex: [/^(RO)([1-9]\d{1,9})$/]
		}
	}
	exports.countries.russia = {
		name: 'Russian Federation',
		codes: ['RU', 'RUS', '643'],
		calcFn: function(vat) {
			function _check10DigitINN(vat, rules) {
				var total = 0
				if (vat.length === 10) {
					for (var i = 0; i < 10; i++) {
						total += +vat.charAt(i) * rules.multipliers.m_1[i]
					}
					total = total % 11
					if (total > 9) {
						total = total % 10
					}
					var expect = +vat.slice(9, 10)
					return total === expect
				}
				return false
			}
			function _check12DigitINN(vat, rules) {
				var total1 = 0
				var total2 = 0
				if (vat.length === 12) {
					for (var j = 0; j < 11; j++) {
						total1 += +vat.charAt(j) * rules.multipliers.m_2[j]
					}
					total1 = total1 % 11
					if (total1 > 9) {
						total1 = total1 % 10
					}
					for (var k = 0; k < 11; k++) {
						total2 += +vat.charAt(k) * rules.multipliers.m_3[k]
					}
					total2 = total2 % 11
					if (total2 > 9) {
						total2 = total2 % 10
					}
					var expect = (total1 === +vat.slice(10, 11))
					var expect2 = (total2 === +vat.slice(11, 12))
					return (expect) && (expect2)
				}
				return false
			}
			return _check10DigitINN(vat, this.rules) || _check12DigitINN(vat, this.rules)
		},
		rules: {
			multipliers: {
				m_1: [2, 4, 10, 3, 5, 9, 4, 6, 8, 0],
				m_2: [7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0],
				m_3: [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0]
			},
			regex: [/^(RU)(\d{10}|\d{12})$/]
		}
	}
	exports.countries.serbia = {
		name: 'Serbia',
		codes: ['RS', 'SRB', '688'],
		calcFn: function(vat) {
			var product = 10
			var sum = 0
			var checkDigit
			for (var i = 0; i < 8; i++) {
				sum = (+vat.charAt(i) + product) % 10
				if (sum === 0) {
					sum = 10
				}
				product = (2 * sum) % 11
			}
			var expect = 1
			checkDigit = (product + (+vat.slice(8, 9))) % 10
			return checkDigit === expect
		},
		rules: {
			regex: [/^(RS)(\d{9})$/]
		}
	}
	exports.countries.slovakia_republic = {
		name: 'Slovakia_',
		codes: ['SK', 'SVK', '703'],
		calcFn: function(vat) {
			var expect = 0
			var checkDigit = (vat % 11)
			return checkDigit === expect
		},
		rules: {
			regex: [/^(SK)([1-9]\d[2346-9]\d{7})$/]
		}
	}
	exports.countries.slovenia = {
		name: 'Slovenia',
		codes: ['SI', 'SVN', '705'],
		calcFn: function(vat) {
			var total = 0
			var expect
			for (var i = 0; i < 7; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 11 - total % 11
			if (total === 10) {
				total = 0
			}
			expect = +vat.slice(7, 8)
			return !!(total !== 11 && total === expect)
		},
		rules: {
			multipliers: [8, 7, 6, 5, 4, 3, 2],
			regex: [/^(SI)([1-9]\d{7})$/]
		}
	}
	exports.countries.spain = {
		name: 'Spain',
		codes: ['ES', 'ESP', '724'],
		calcFn: function(vat) {
			var i = 0
			var total = 0
			var temp
			var expect
			if (this.rules.additional[0].test(vat)) {
				for (i = 0; i < 7; i++) {
					temp = vat.charAt(i + 1) * this.rules.multipliers[i]
					if (temp > 9)
						total += Math.floor(temp / 10) + temp % 10
					else
						total += temp
				}
				total = 10 - total % 10
				if (total === 10) {
					total = 0
				}
				expect = +vat.slice(8, 9)
				return total === expect
			} else if (this.rules.additional[1].test(vat)) {
				for (i = 0; i < 7; i++) {
					temp = vat.charAt(i + 1) * this.rules.multipliers[i]
					if (temp > 9)
						total += Math.floor(temp / 10) + temp % 10
					else
						total += temp
				}
				total = 10 - total % 10
				total = String.fromCharCode(total + 64)
				expect = vat.slice(8, 9)
				return total === expect
			} else if (this.rules.additional[2].test(vat)) {
				var tempnumber = vat
				if (tempnumber.substring(0, 1) === 'Y') tempnumber = tempnumber.replace(/Y/, '1')
				if (tempnumber.substring(0, 1) === 'Z') tempnumber = tempnumber.replace(/Z/, '2')
				expect = 'TRWAGMYFPDXBNJZSQVHLCKE'.charAt(+tempnumber.substring(0, 8) % 23)
				return tempnumber.charAt(8) === expect
			} else if (this.rules.additional[3].test(vat)) {
				expect = 'TRWAGMYFPDXBNJZSQVHLCKE'.charAt(+vat.substring(1, 8) % 23)
				return vat.charAt(8) === expect
			} else return false
		},
		rules: {
			multipliers: [2, 1, 2, 1, 2, 1, 2],
			regex: [
				/^(ES)([A-Z]\d{8})$/,
				/^(ES)([A-HN-SW]\d{7}[A-J])$/,
				/^(ES)([0-9YZ]\d{7}[A-Z])$/,
				/^(ES)([KLMX]\d{7}[A-Z])$/
			],
			additional: [
				/^[A-H|J|U|V]\d{8}$/,
				/^[A-H|N-S|W]\d{7}[A-J]$/,
				/^[0-9|Y|Z]\d{7}[A-Z]$/,
				/^[K|L|M|X]\d{7}[A-Z]$/
			]
		}
	}
	exports.countries.sweden = {
		name: 'Sweden',
		codes: ['SE', 'SWE', '752'],
		calcFn: function(vat) {
			var expect
			var R = 0
			var digit
			for (var i = 0; i < 9; i = i + 2) {
				digit = +vat.charAt(i)
				R += Math.floor(digit / 5) + ((digit * 2) % 10)
			}
			var S = 0
			for (var j = 1; j < 9; j = j + 2) {
				S += +vat.charAt(j)
			}
			var checkDigit = (10 - (R + S) % 10) % 10
			expect = +vat.slice(9, 10)
			return checkDigit === expect
		},
		rules: {
			regex: [/^(SE)(\d{10}01)$/]
		}
	}
	exports.countries.switzerland = {
		name: 'Switzerland',
		codes: ['CH', 'CHE', '756'],
		calcFn: function(vat) {
			var total = 0
			for (var i = 0; i < 8; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			total = 11 - total % 11
			if (total === 10) return false
			if (total === 11) total = 0
			var expect = +vat.substr(8, 1)
			return total === expect
		},
		rules: {
			multipliers: [5, 4, 3, 2, 7, 6, 5, 4],
			regex: [/^(CHE)(\d{9})(MWST)?$/]
		}
	}
	exports.countries.united_kingdom = {
		name: 'United Kingdom',
		codes: ['GB', 'GBR', '826'],
		calcFn: function(vat) {
			var total = 0
			var expect
			if (vat.substr(0, 2) === 'GD') {
				expect = 500
				return vat.substr(2, 3) < expect
			}
			if (vat.substr(0, 2) === 'HA') {
				expect = 499
				return vat.substr(2, 3) > expect
			}
			if (+vat.slice(0) === 0) return false
			var no = +vat.slice(0, 7)
			for (var i = 0; i < 7; i++) {
				total += +vat.charAt(i) * this.rules.multipliers[i]
			}
			var checkDigit = total
			while (checkDigit > 0) {
				checkDigit = checkDigit - 97
			}
			checkDigit = Math.abs(checkDigit)
			if (checkDigit === +vat.slice(7, 9) && no < 9990001 && (no < 100000 || no > 999999) && (no < 9490001 || no > 9700000)) return true
			if (checkDigit >= 55)
				checkDigit = checkDigit - 55
			else
				checkDigit = checkDigit + 42
			expect = +vat.slice(7, 9)
			return !!(checkDigit === expect && no > 1000000)
		},
		rules: {
			multipliers: [8, 7, 6, 5, 4, 3, 2],
			regex: [
				/^(GB)?(\d{9})$/,
				/^(GB)?(\d{12})$/,
				/^(GB)?(GD\d{3})$/,
				/^(GB)?(HA\d{3})$/
			]
		}
	}
	if (typeof module === 'object' && module.exports) module.exports = exports
	return exports
})()
