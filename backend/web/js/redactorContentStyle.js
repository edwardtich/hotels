function renderCSSForSelector(css, selector) {
    return ((css+"")||"").replace(/\n|\t/g, " ")
        .replace(/\s+/g, " ")
        .replace(/\s*\/\*.*?\*\/\s*/g, " ")
        .replace(/(^|\})(.*?)(\{)/g, function($0, $1, $2, $3) {
            var collector = [], parts = $2.split(",");
            for (var i in parts) {
                collector.push(selector + " " + parts[i].replace(/^\s*|\s*$/, ""));
            }
            return $1 + " " + collector.join(", ") + " " + $3;
        });
}

function applyCSSToElement(css, elementSelector) {
    $("head").append("<style type=\"text/css\">" + renderCSSForSelector(css, elementSelector) + "</style>");
}

function applyCSSFileToElement(cssUrl, elementSelector, callbackSuccess, callbackError) {
    callbackSuccess = callbackSuccess || function(){};
    callbackError = callbackError || function(){};
    $.ajax({
        url: cssUrl,
        dataType: "text",
        success: function(data) {
            applyCSSToElement(data, elementSelector);
            callbackSuccess();
        },
        error: function(jqXHR,t) {
            callbackError();
            console.log(t);
        }
    })
}