// Go through all links
$('a[href]').each(function () {
    var href = $(this).attr('href')
    
    if (href.match(/youtube\.com\/(v|watch)/i))
    {
        //var href = $(this).attr('href').replace(/\?|&|=/g, function (v) { return escape(v) })
        var href = href.replace(/watch\?v=([^&]+)/, 'v/$1')
        
        $(this).attr('rel', 'shadowbox[youtube];height=385;width=480;player=swf;content=' + href)
    }
    else if (href.match(/\.(jpe?g|png|gif|mov|swf)/))
    {
        $(this).attr('rel', 'shadowbox')
    }
})

Shadowbox.init({
    flashParams: {
        allowscriptaccess: "always",
        allowfullscreen:   "true",
        wmode:             "opaque"
    },
    flashVars: {
        fs:          1,
        color1:      "0x006bbb",
        color2:      "0x006bbb",
        backcolor:   "0x006bbb",
        frontcolor:  "0xFFFFFF",
        lightcolor:  "0xFFFFFF",
        screencolor: "0x000000",
        provider:    "youtube",
        icons:       true, 
    }
})