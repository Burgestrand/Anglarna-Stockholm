// Go through all links
$('a[href]').each(function () {
    var href = $(this).attr('href')
    
    if ($(this).attr('rel').match(/shadowbox/)) return;
    
    if (href.match(/youtube\.com\/(v|watch)/i))
    {
        //var href = $(this).attr('href').replace(/\?|&|=/g, function (v) { return escape(v) })
        var href = href.replace(/watch\?v=([^&]+)/, 'v/$1')
        
        $(this).attr('rel', 'shadowbox[youtube];height=385;width=480;player=swf;content=' + href)
    }
    else if (href.match(/\.(jpe?g|png|gif)/))
    {
        $(this).attr('rel', 'shadowbox[img]')
    }
    else if ($(this).attr('rel') == 'delete')
    {
        $(this).click(function (e) {
            e.preventDefault()
            if (confirm('Vill du verkligen ta bort denna post?'))
            {
                var split = href.split('?')
                var url   = split[0]
                var query = split[1]
                var $li   = $(this).closest('li')
                
                jQuery.ajax({
                    type: 'delete',
                    url: url,
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    data: query,
                    success: function (data, status)
                    {
                        $li.fadeOut('fast', function () { $li.remove() })
                    },
                    error: function (req, status, error)
                    {
                        alert("Fel (" + req.status + "): " + req.responseText);
                    }
                })
            }
        })
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