!function (o) {
    o.fn.lazyyard = function (n) {
        return n = o.extend({
            onScroll: !0
        }, n), this.each(function (t, c, e) {
            var r = o(this),
                l = o(window),
                a = r.attr("src"),
                h = "w" + Math.round(r.width() + r.width() / 10) + "-h" + Math.round(r.height() + r.height() / 10) + "-p-k-no-nu";

            function s() {
                var o = new Image;
                o.onload = function () {
                    r.attr('src', '' + this.src + '').addClass("lazy-yard")
                }, o.src = t
            }
            a.match("resources.blogblog.com") && (a = "undefined" != typeof noThumbnail ? noThumbnail : "//1.bp.blogspot.com/-rI4UCIrwEI4/YN3nGkf0nCI/AAAAAAAAAD0/DQ6fW7eCps8NL7S0oh374KFg1MsWUf2GQCLcBGAsYHQ/s72-c/ptb-nth.png"), a.match("blogger.googleusercontent.com") && a.match("=") && (e = a.split("="), a = e[1] && "" != e[1].trim() ? e[0] + "=w72-h72-p-k-no-nu" : a), a.match("blogger.googleusercontent.com") && !a.match("=") && (a += "=w72-h72-p-k-no-nu"), t = a.match("/s72-c") ? a.replace("/s72-c", "/" + h) : a.match("/w72-h") ? a.replace("/w72-h72-p-k-no-nu", "/" + h) : a.match("=w72-h") ? a.replace("=w72-h72-p-k-no-nu", "=" + h) : a, 1 == n.onScroll ? l.on("load resize scroll", function o() {
                l.scrollTop() + l.height() >= r.offset().top && (l.off("load resize scroll", o), s())
            }).trigger("scroll") : l.on("load", function o() {
                l.off("load", o), s()
            }).trigger("load")
        })
    }
}(jQuery);
$(function () {
    $('.index-post .post-image-link .post-thumb, .PopularPosts .post-image-link .post-thumb, .FeaturedPost .post-image-link .post-thumb,.about-author .author-avatar, .item-post .post-body img').lazyyard();
    $('#main-menu').each(function () {
        var iTms = $(this).find('.LinkList ul > li').children('a'),
            iLen = iTms.length;
        for (var i = 0; i < iLen; i++) {
            var i1 = iTms.eq(i),
                t1 = i1.text();
            if (t1.charAt(0) !== '_') {
                var i2 = iTms.eq(i + 1),
                    t2 = i2.text();
                if (t2.charAt(0) === '_') {
                    var l1 = i1.parent();
                    l1.append('<ul class="sub-menu m-sub"/>')
                }
            }
            if (t1.charAt(0) === '_') {
                i1.text(t1.replace('_', ''));
                i1.parent().appendTo(l1.children('.sub-menu'))
            }
        }
        for (var i = 0; i < iLen; i++) {
            var i3 = iTms.eq(i),
                t3 = i3.text();
            if (t3.charAt(0) !== '_') {
                var i4 = iTms.eq(i + 1),
                    t4 = i4.text();
                if (t4.charAt(0) === '_') {
                    var l2 = i3.parent();
                    l2.append('<ul class="sub-menu2 m-sub"/>')
                }
            }
            if (t3.charAt(0) === '_') {
                i3.text(t3.replace('_', ''));
                i3.parent().appendTo(l2.children('.sub-menu2'))
            }
        }
        $('#main-menu ul li ul').parent('li').addClass('has-sub');
        $('#main-menu .widget').addClass('show-menu')
    });
    $('#main-menu-nav').clone().appendTo('.mobile-menu');
    $('.mobile-menu .has-sub').append('<div class="submenu-toggle"/>');
    $('.mobile-menu ul > li a').each(function () {
        var $this = $(this),
            text = $this.attr('href').trim(),
            type = text.toLowerCase(),
            map = text.split('/'),
            label = map[0];
        if (type.match('mega-menu')) {
            $this.attr('href', '/search/label/' + label + '?&max-results=' + postPerPage)
        }
    });
    $('.mobile-menu-toggle').on('click', function () {
        $('body').toggleClass('nav-active')
    });
    $('.mobile-menu ul li .submenu-toggle').on('click', function ($this) {
        if ($(this).parent().hasClass('has-sub')) {
            $this.preventDefault();
            if (!$(this).parent().hasClass('show')) {
                $(this).parent().addClass('show').children('.m-sub').slideToggle(170)
            } else {
                $(this).parent().removeClass('show').find('> .m-sub').slideToggle(170)
            }
        }
    });
    $('.show-search').on('click', function () {
        $('#nav-search, .mobile-search-form').fadeIn(250).find('input').focus()
    });
    $('.hide-search').on('click', function () {
        $('#nav-search, .mobile-search-form').fadeOut(250).find('input').blur()
    });
    $('.language-selector .language-toggle').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('open');
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.language-selector').length) {
            $('.language-dropdown').removeClass('open');
        }
    });
    $("#break-section .PopularPosts .ticker-widget").owlCarousel({
        items: 3,
        slideBy: 1,
        smartSpeed: 1000,
        animateIn: 'fadeInRight',
        animateOut: 'fadeOutRight',
        rtl: false,
        nav: true,
        navText: ['', ''],
        loop: true,
        autoplay: true,
        autoplayHoverPause: true,
        dots: false,
        mouseDrag: false,
        touchDrag: false,
        freeDrag: false,
        pullDrag: false,
        responsive: {
            0: {
                items: 1
            },
            541: {
                items: 1
            },
            681: {
                items: 1
            },
            769: {
                items: 1
            },
            1020: {
                items: 2
            }
        }
    });
    // $('.Label a, a.b-label, a.post-tag').attr('href', function ($this, href) {
    //     return href.replace(href, href + '?&max-results=' + postPerPage)
    // });
    $('#ty-post-before-ad .widget').each(function () {
        var $t = $(this);
        if ($t.length) {
            $t.appendTo($('#prev-ad'))
        }
    });
    $('#ty-post-after-ad .widget').each(function () {
        var $t = $(this);
        if ($t.length) {
            $t.appendTo($('#nxt-ad'))
        }
    });

    $('.avatar-image-container img').attr('src', function ($this, i) {
        i = i.replace('/s35-c/', '/s45-c/');
        i = i.replace('//img1.blogblog.com/img/blank.gif', '//4.bp.blogspot.com/-uCjYgVFIh70/VuOLn-mL7PI/AAAAAAAADUs/Kcu9wJbv790hIo83rI_s7lLW3zkLY01EA/s55-r/avatar.png');
        return i
    });

    $('.author-description a').each(function () {
        $(this).attr('target', '_blank')
    });

    // $('.post-nav').each(function () {
    //     var getURL_prev = $('a.prev-post-link').attr('href'),
    //         getURL_next = $('a.next-post-link').attr('href');
    //     $.ajax({
    //         url: getURL_prev,
    //         type: 'get',
    //         success: function (prev) {
    //             var title = $(prev).find('.blog-post h1.post-title').text();
    //             $('.post-prev a .post-nav-inner p').text(title)
    //         }
    //     });
    //     $.ajax({
    //         url: getURL_next,
    //         type: 'get',
    //         success: function (next) {
    //             var title = $(next).find('.blog-post h1.post-title').text();
    //             $('.post-next a .post-nav-inner p').text(title)
    //         }
    //     })
    // });
    $('.post-body strike').each(function () {
        var $this = $(this),
            type = $this.text();
        if (type.match('left-sidebar')) {
            $this.replaceWith('<style>.item #main-wrapper{float:right}.item #sidebar-wrapper{float:left}</style>')
        }
        if (type.match('right-sidebar')) {
            $this.replaceWith('<style>.item #main-wrapper{float:left}.item #sidebar-wrapper{float:right}</style>')
        }
        if (type.match('full-width')) {
            $this.replaceWith('<style>.item #main-wrapper{width:100%}.item #sidebar-wrapper{display:none}</style>')
        }
    });
    $('#main-wrapper, #sidebar-wrapper').each(function () {
        if (fixedSidebar == true) {
            $(this).theiaStickySidebar({
                additionalMarginTop: 30,
                additionalMarginBottom: 30
            })
        }
    });
    $('.back-top').each(function () {
        var $this = $(this);
        $(window).on('scroll', function () {
            $(this).scrollTop() >= 100 ? $this.fadeIn(250) : $this.fadeOut(250)
        }), $this.click(function () {
            $('html, body').animate({
                scrollTop: 0
            }, 500)
        })
    });
    $('#main-menu #main-menu-nav li').each(function () {
        var li = $(this),
            text = li.find('a').attr('href').trim(),
            $this = li,
            type = text.toLowerCase(),
            map = text.split('/'),
            label = map[0];
        ajaxPosts($this, type, 5, label)
    });
    $('#break-section .widget-content').each(function () {
        var $this = $(this),
            text = $this.text().trim(),
            type = text.toLowerCase(),
            map = text.split('/'),
            num = map[0],
            label = map[1];
        ajaxPosts($this, type, num, label)
    });
    $('#hot-section .widget-content').each(function () {
        var $this = $(this),
            text = $this.text().trim(),
            type = text.toLowerCase(),
            map = text.split('/'),
            label = map[0];
        ajaxPosts($this, type, 4, label)
    });
    $('.featured-posts .widget-content').each(function () {
        var $this = $(this),
            text = $this.text().trim(),
            type = text.toLowerCase(),
            map = text.split('/'),
            num = map[0],
            label = map[1];
        ajaxPosts($this, type, num, label)
    });
    $('.common-widget .widget-content').each(function () {
        var $this = $(this),
            text = $this.text().trim(),
            type = text.toLowerCase(),
            map = text.split('/'),
            num = map[0],
            label = map[1];
        ajaxPosts($this, type, num, label)
    });

    $('.related-ready').each(function () {
        const $this = $(this);
        const label = $this.find('.related-tag').data('label');
        const currentId = $this.find('.related-tag').data('current-id');
        ajaxPosts($this, 'related', 3, label, currentId);
    });

    function post_link(feed, i) {
        return feed[i].url;
    }

    function post_title(feed, i, link) {
        const n = feed[i].title;
        return '<a href="' + link + '">' + n + '</a>'
    }

    function post_author(feed, i) {
        if (feed[i].author == undefined || !feed[i].author) {
            return '';
        }

        const n = feed[i].author.name;

        if (!n) {
            return '';
        }

        return '<span class="post-author"><a>' + n + '</a></span>'
    }

    function post_date(feed, i) {
        return '<span class="post-date">' + feed[i].date + '</span>'
    }

    function FeatImage(feed, i, img, width = null, height = null) {
        if (feed[i].thumbnail) {
            var src = feed[i].thumbnail
        } else {
            src = noThumbnail
        }

        if (src.includes(juzaweb.imageUrl) && (width || height)) {
            let currentSize = src.split('/')[3];
            let w = width ? width : 'auto';
            let h = height ? height : 'auto';
            src = src.replace(`/${currentSize}/`, `/cover:${w}x${h}/`);
        }

        return '<img class="post-thumb lazy-yard" alt="" src="' + src + '"/>';
    }

    function post_label(feed, i) {
        let code;
        if (feed[i].category != undefined) {
            let tag = feed[i].category.name;
            code = '<span class="post-tag">' + tag + '</span>';
        } else {
            code = ''
        }
        return code
    }

    function post_snip(feed, i) {
        return '<p class="post-snippet">' + feed[i].description + '</p>'
    }

    function ajaxPosts($this, type, num, label, currentId = null) {
        if (type.match('mega-menu') || type.match('ticker-posts') || type.match('hot-posts') || type.match('grid-post') || type.match('post-list') || type.match('related')) {
            let url = '';
            if (label == 'recent') {
                url = loadPostUrl + '?type=recent&limit=' + num;
            } else if (label == 'random') {
                url = loadPostUrl + '/?type=random&limit=' + num;
            } else {
                url = loadPostUrl + '/?type=category&category=' + label + '&limit=' + num;
            }

            if (type.match('related') && currentId) {
                url += '&exclude=' + currentId;
            }

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                beforeSend: function () {
                    if (type.match('ticker-posts')) {
                        $this.html('<div class="hot-loader"/>').parent().addClass('show-ticker')
                    } else if (type.match('hot-posts')) {
                        $this.html('<div class="hot-loader"/>').parent().addClass('show-hot')
                    } else if (type.match('grid-post')) {
                        $this.html('<div class="hot-loader"/>').parent().addClass('show-grid')
                    }
                },
                success: function (json) {
                    if (type.match('mega-menu')) {
                        var kode = '<ul class="mega-menu-inner">'
                    } else if (type.match('ticker-posts')) {
                        var kode = '<ul class="ticker-widget">'
                    } else if (type.match('hot-posts')) {
                        var kode = '<ul class="hot-posts">'
                    } else if (type.match('grid-post')) {
                        var kode = '<ul class="grid-big">'
                    } else if (type.match('post-list')) {
                        var kode = '<ul class="custom-widget">'
                    } else if (type.match('related')) {
                        var kode = '<ul class="related-posts">'
                    }
                    var entry = json;
                    if (entry != undefined) {
                        for (let i = 0, feed = entry; i < feed.length; i++) {
                            let imgWidth = null, imgHeight = null;

                            // Desktop
                            if (window.screen.width > 1024) {
                                if (type.match('related')) {
                                    imgWidth = 229;
                                    imgHeight = 120;
                                }

                                if (type.match('ticker-posts')) {
                                    imgWidth = 35;
                                    imgHeight = 30;
                                }

                                if(type.match('hot-posts')) {
                                    if (i == 0) {
                                        imgWidth = 615;
                                        imgHeight = 415;
                                    } else {
                                        imgWidth = 180;
                                        imgHeight = 125;
                                    }
                                }

                                if (type.match('grid-post')) {
                                    imgWidth = 339;
                                    imgHeight = 180;
                                }
                            }

                            // Tablet
                            if (window.screen.width <= 1024 && window.screen.width > 768) {
                                if (type.match('related')) {
                                    imgWidth = 241;
                                    imgHeight = 120;
                                }

                                if (type.match('ticker-posts')) {
                                    imgWidth = 35;
                                    imgHeight = 30;
                                }

                                if(type.match('hot-posts')) {
                                    if (i == 0) {
                                        imgWidth = 615;
                                        imgHeight = 415;
                                    } else {
                                        imgWidth = 180;
                                        imgHeight = 125;
                                    }
                                }

                                if (type.match('grid-post')) {
                                    imgWidth = 339;
                                    imgHeight = 180;
                                }
                            }

                            // Mobile
                            if (window.screen.width <= 768) {
                                if (type.match('related')) {
                                    imgWidth = 75;
                                    imgHeight = 60;
                                }

                                if (type.match('ticker-posts')) {
                                    imgWidth = 25;
                                    imgHeight = 30;
                                }

                                if(type.match('hot-posts')) {
                                    if (i == 0) {
                                        imgWidth = 280;
                                        imgHeight = 320;
                                    } else {
                                        imgWidth = 280;
                                        imgHeight = 150;
                                    }
                                }

                                if (type.match('grid-post')) {
                                    imgWidth = 280;
                                    imgHeight = 180;
                                }
                            }

                            var link = post_link(feed, i),
                                title = post_title(feed, i, link),
                                image = FeatImage(feed, i, link, imgWidth, imgHeight),
                                tag = post_label(feed, i),
                                author = post_author(feed, i),
                                date = post_date(feed, i),
                                snip = post_snip(feed, i);
                            var kontent = '';
                            if (type.match('mega-menu')) {
                                kontent += '<div class="mega-item item-' + i + '"><div class="mega-content"><div class="post-image-wrap"><a class="post-image-link" href="' + link + '">' + image + '</a></div><h2 class="post-title">' + title + '</h2></div></div>'
                            } else if (type.match('ticker-posts')) {
                                kontent += '<li class="ticker-item item-' + i + '"><a class="post-image-link" href="' + link + '">' + image + '</a><div class="post-info">' + tag + '<h2 class="post-title">' + title + '</h2></div></li>'
                            } else if (type.match('hot-posts')) {
                                if (i == 0) {
                                    kontent += '<li class="hot-item item-' + i + '"><div class="hot-item-inner"><div class="post-image-wrap"><a class="post-image-link" href="' + link + '">' + image + '</a><div class="post-info">' + tag + '<h2 class="post-title">' + title + '</h2>' + snip + '<div class="post-meta">' + author + date + '</div></div></div></div></li>'
                                } else {
                                    kontent += '<li class="hot-item item-' + i + '"><div class="hot-item-inner"><a class="post-image-link" href="' + link + '">' + image + '</a><div class="post-info">' + tag + '<h2 class="post-title">' + title + '</h2><div class="post-meta">' + date + '</div></div></li>'
                                }
                            } else if (type.match('grid-post')) {
                                kontent += '<li class="feat-item item-big item-' + i + '"><div class="feat-inner"><a class="post-image-link" href="' + link + '">' + tag + image + '</a><div class="post-info"><h2 class="post-title">' + title + '</h2><div class="post-meta">' + author + '<span class="separator">-</span>' + date + '</div></div></div></li>'
                            } else if (type.match('post-list')) {
                                kontent += '<li class="item-' + i + '"><a class="post-image-link" href="' + link + '">' + image + '</a><div class="post-info"><h2 class="post-title">' + title + '</h2><div class="post-meta">' + date + '</div></div></div></li>'
                            } else if (type.match('related')) {
                                kontent += '<li class="related-item item-' + i + '"><a class="post-image-link" href="' + link + '">' + image + '</a><h2 class="post-title">' + title + '</h2><div class="post-meta">' + date + '</div></li>'
                            }
                            kode += kontent
                        }
                        kode += '</ul>'
                    } else {
                        kode = '<ul class="no-posts">Error: No Posts Found <i class="fa fa-frown"/></ul>'
                    }
                    if (type.match("mega-menu")) {
                        $this.addClass('has-sub mega-menu').append(kode);
                        $this.find('a:first').attr('href', function ($this, href) {
                            if (label == 'recent' || label == 'random') {
                                href = href.replace(href, '/search/?&max-results=' + postPerPage)
                            } else {
                                href = href.replace(href, '/search/label/' + label + '?&max-results=' + postPerPage)
                            }
                            return href
                        })
                    } else if (type.match('ticker-posts')) {
                        $this.html(kode).parent().addClass('show-ticker');
                        var $newsticker = $this.find('.ticker-widget');
                        $newsticker.owlCarousel({
                            items: 2,
                            slideBy: 1,
                            smartSpeed: 1000,
                            animateIn: 'fadeInLeft',
                            animateOut: 'fadeOutRight',
                            rtl: false,
                            nav: true,
                            navText: ['', ''],
                            loop: true,
                            autoplay: true,
                            autoplayHoverPause: true,
                            dots: false,
                            mouseDrag: false,
                            touchDrag: false,
                            freeDrag: false,
                            pullDrag: false,
                            responsive: {
                                0: {
                                    items: 1
                                },
                                541: {
                                    items: 1
                                },
                                681: {
                                    items: 1
                                },
                                769: {
                                    items: 1
                                },
                                1020: {
                                    items: 2
                                }
                            }
                        })
                    } else if (type.match('hot-posts')) {
                        $this.html(kode).parent().addClass('show-hot')
                    } else if (type.match('grid-post')) {
                        $this.html(kode).parent().addClass('show-grid')
                    } else {
                        $this.html(kode)
                    }
                    $this.find('.post-thumb').lazyyard()
                }
            })
        }
    }
    // $('.blog-post-comments').each(function () {
    //     var system = commentsSystem,
    //         disqus_url = disqus_blogger_current_url,
    //         disqus = '<div id="disqus_thread"/>',
    //         current_url = $(location).attr('href'),
    //         facebook = '<div class="fb-comments" data-width="100%" data-href="' + current_url + '" data-numposts="5"></div>',
    //         sClass = 'comments-system-' + system;
    //     if (system == 'blogger') {
    //         $(this).addClass(sClass).show()
    //     } else if (system == 'disqus') {
    //         (function () {
    //             var dsq = document.createElement('script');
    //             dsq.type = 'text/javascript';
    //             dsq.async = true;
    //             dsq.src = '//' + disqusShortname + '.disqus.com/embed.js';
    //             (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq)
    //         })();
    //         $('#comments, #gpluscomments').remove();
    //         $(this).append(disqus).addClass(sClass).show()
    //     } else if (system == 'facebook') {
    //         $('#comments, #gpluscomments').remove();
    //         $(this).append(facebook).addClass(sClass).show()
    //     } else if (system == 'hide') {
    //         $(this).hide()
    //     } else {
    //         $(this).addClass('comments-system-default').show()
    //     }
    // })
});

function shortCodeIfy(e, t, a) {
    for (var s = e.split("$"), i = /[^{\}]+(?=})/g, r = 0; r < s.length; r++) {
        var o = s[r].split("=");
        if (o[0].trim() == t) return null != (a = o[1]).match(i) && String(a.match(i)).trim()
    }
    return !1
}
$(".post-body a").each(function () {
    var e = $(this),
        t = e.html(),
        a = t.toLowerCase(),
        s = shortCodeIfy(t, "text"),
        i = shortCodeIfy(t, "icon"),
        r = shortCodeIfy(t, "color");
    a.match("getbutton") && 0 != s && (e.addClass("button btn").text(s), 0 != i && e.addClass(i), 0 != r && e.addClass("colored-button").attr("style", "background-color:" + r + ";"))
}), $(".post-body b").each(function () {
    var e = $(this),
        t = e.text(),
        a = t.toLowerCase().trim();
    a.match("{tocify}") && (t = 0 != shortCodeIfy(t, "title") ? shortCodeIfy(t, "title") : "Table of Contents", e.replaceWith('<div class="tocify-wrap"><div class="tocify-inner"><a href="javascript:;" class="tocify-title" role="button" title="' + t + '"><span class="tocify-title-text">' + t + '</span></a><ol id="tocify"></ol></div></div>'), $(".tocify-title").each(function (e) {
        (e = $(this)).on("click", function () {
            e.toggleClass("is-expanded"), $("#tocify").slideToggle(170)
        })
    }), $("#tocify").toc({
        content: "#post-body",
        headings: "h2,h3,h4"
    }), $("#tocify li a").each(function (e) {
        (e = $(this)).click(function () {
            return $("html,body").animate({
                scrollTop: ($(e.attr("href")).offset().top) - 20
            }, 500), !1
        })
    })), a.match("{contactform}") && (e.replaceWith('<div class="contact-form"/>'), $(".contact-form").append($("#ContactForm1")))
}), $(".post-body blockquote").each(function () {
    var e = $(this),
        t = e.text().toLowerCase().trim(),
        a = e.html();
    if (t.match("{alertsuccess}")) {
        const t = a.replace("{alertSuccess}", "");
        e.replaceWith('<div class="alert-message alert-success">' + t + "</div>")
    }
    if (t.match("{alertinfo}")) {
        const t = a.replace("{alertInfo}", "");
        e.replaceWith('<div class="alert-message alert-info">' + t + "</div>")
    }
    if (t.match("{alertwarning}")) {
        const t = a.replace("{alertWarning}", "");
        e.replaceWith('<div class="alert-message alert-warning">' + t + "</div>")
    }
    if (t.match("{alerterror}")) {
        const t = a.replace("{alertError}", "");
        e.replaceWith('<div class="alert-message alert-error">' + t + "</div>")
    }
    if (t.match("{codebox}")) {
        const t = a.replace("{codeBox}", "");
        e.replaceWith('<pre class="code-box">' + t + "</pre>")
    }
}), $("#post-body iframe").each(function () {
    var e = $(this);
    e.attr("src").match("www.youtube.com") && e.wrap('<div class="responsive-video-wrap"/>')
})
