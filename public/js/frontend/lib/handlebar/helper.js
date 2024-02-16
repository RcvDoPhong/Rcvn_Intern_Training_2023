Handlebars.registerHelper("log", function (value) {
    console.log(value);
});

Handlebars.registerHelper("formatNumber", function (number) {
    if (typeof number === "number") {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    return number;
});

Handlebars.registerHelper("ifeq", function (a, b, options) {
    if (a == b) {
        return options.fn(this);
    }
    return options.inverse(this);
});

Handlebars.registerHelper("ifnoteq", function (a, b, options) {
    if (a != b) {
        return options.fn(this);
    }
    return options.inverse(this);
});

Handlebars.registerHelper('gt', function (a, b, options) {
    return a > b;
});

Handlebars.registerHelper("lt", function (a, b, options) {
    return a < b;
});
