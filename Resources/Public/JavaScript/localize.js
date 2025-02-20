function changeLocalizationLabel(currentLabel, newLabel) {
    $('[data-localize=' + currentLabel + ']').text(l[cLang][newLabel]);
}
