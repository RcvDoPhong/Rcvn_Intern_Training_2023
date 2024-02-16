function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function formatNumberToNum(str) {
    let convertStr = String(str);
    return parseInt(convertStr.replace(/\./g, ""));
}
