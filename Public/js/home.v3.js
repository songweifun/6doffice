var InterestSoliderNew = function() {
    return this.inits.apply(this, arguments)
};
InterestSoliderNew.prototype = {
    inits: function(a) {
        var b = this,
        c = $.browser.msie && $.browser.version <= 6;
        this.$box = $(a.box),
        this.$navs = $(a.navs),
        this.$lists = this.$box.find(a.lists),
        this.waiters = [],
        this.pinterval = null,
        this.current = a.current,
        this.length = this.$lists.size(),
        this._current = 0,
        this._last = 0,
        this._playing = !1,
        this.movewidth = this.$box.width(),
        this.autoloop = a.autoloop === undefined ? !0: !1,
        this.eventtype = a.eventtype || "mouseover",
        this.ie6 && document.execCommand("BackgroundImageCache", !1, !0),
        b.$lists.eq(b._current).siblings(a.lists).hide(),
        this.$navs.each(function(a) {
            $(this)[b.eventtype](function() {
                b._current != a && (clearInterval(b.waiters[a]), b.waiters[a] = setInterval(function() {
                    b.play(a)
                },
                50))
            }),
            $(this).mouseout(function() {
                clearInterval(b.waiters[a])
            })
        }),
        a.prev && $(a.prev).click(function() {
            b.prev()
        }),
        a.next && $(a.next).click(function() {
            b.next()
        }),
        this.$box.hover(function() {
            b.pause()
        },
        function() {
            b.autoloop && b.loop()
        }),
        this.$navs.eq(0).parent().hover(function() {
            b.pause()
        },
        function() {
            b.autoloop && b.loop()
        }),
        this.autoloop && this.loop(),
        this.catchable()
    },
    catchable: function() {
        var a = this;
        this.$box.catchable({
            threshold: "0 0",
            catched: function() {
                a.autoloop && a.loop()
            },
            lost: function() {
                a.pause()
            }
        }).trigger("snap")
    },
    play: function(a) {
        var a = a || 0,
        b = this._current,
        c = a > b;
        if (this._playing || b == a) return;
        a == 0 && b == this.length - 1 && (c = !0),
        b == 0 && a == this.length - 1 && (c = !1);
        var d = this,
        e = d.$box,
        f = d.$lists.eq(d._last),
        g = d.$lists.eq(a);
        g[c ? "appendTo": "prependTo"](e),
        g.find("img").trigger("catched"),
        g.css({
            marginLeft: c ? 0: -this.movewidth
        }),
        g.show();
        var h = c ? f: g;
        this._playing = !0,
        h.animate({
            marginLeft: c ? -this.movewidth: 0
        },
        800, 
        function() {
            f.hide().css("margin-left", 0),
            g.css({
                marginLeft: 0
            }),
            d._playing = !1,
            d._last = d._current
        }),
        this.selectNav(a)
    },
    pause: function() {
        clearTimeout(this.pinterval)
    },
    loop: function() {
        var a = this;
        clearTimeout(this.pinterval),
        this.pinterval = setTimeout(function() {
            a.next(),
            a.loop()
        },
        5e3)
    },
    prev: function() {
        this.play(this.prevIndex())
    },
    next: function() {
        this.play(this.nextIndex())
    },
    first: function() {
        return this.$box.find(this.lists + ":visible").eq(0)
    },
    last: function() {
        return this.$box.find(this.lists + ":visible").eq( - 1)
    },
    nextIndex: function() {
        return (this._current + 1) % this.length
    },
    prevIndex: function() {
        return (this.length + this._current - 1) % this.length
    },
    selectNav: function(a) {
        this._current = a || 0,
        this.$navs.removeClass(this.current).eq(a).addClass(this.current)
    }
},
$.fn.tabView = function(a) {
    var b = {
        btncont: "",
        btnAddClass: "on",
        tabcont: ".tabcont",
        tabcontAddClass: "on",
        autoView: !1,
        autoSpeed: 3,
        callback: null
    };
    return a = $.extend({},
    b, a),
    $(this).each(function() {
        function d() {
            var e = b.find("." + a.btncont).index(b.find("." + a.btnAddClass));
            e == b.find("." + a.btncont).size() - 1 ? b.find("." + a.btncont).eq(0).trigger("click") : b.find("." + a.btncont).eq(e + 1).trigger("click"),
            c = setTimeout(d, a.autoSpeed * 1e3)
        }
        var b = $(this),
        c;
        $(this).find(a.btncont).click(function() {
            var c = b.find(a.btncont).index($(this));
            $(this).addClass(a.btnAddClass).siblings().removeClass(a.btnAddClass),
            b.find(a.tabcont).eq(c).addClass(a.tabcontAddClass).siblings(a.tabcont).removeClass(a.tabcontAddClass),
            a.callback && a.callback(c)
        });
        if (!a.autoView) return;
        c = setTimeout(d, a.autoSpeed * 1e3),
        $(this).find(a.btncont).hover(function() {
            window.clearTimeout(c)
        },
        function() {
            c = setTimeout(d, 1e3)
        })
    })
},
$(function() {
    function k() {
        var a = $(".sagent-box ul").css("left");
        return a
    }
    function l() {
        var a = $("#agent_num .anum_t").text();
        return parseInt(a)
    }
    function m() {
        var a = parseInt(k());
        a == i ? ($("#agent_num .anum_t").text("1"), a = 0) : ($("#agent_num .anum_t").text(l() + 1), a -= 210),
        $(".sagent-box ul").css("left", a)
    }
    function n() {
        var a = parseInt(k());
        a == 0 ? (a = i, $("#agent_num .anum_t").text(f)) : ($("#agent_num .anum_t").text(l() - 1), a += 210),
        $(".sagent-box ul").css("left", a)
    }
    var a = [];
    $("#tab1").tabView({
        btncont: "#foucs_tab a",
        btnAddClass: "on",
        tabcont: ".tabcont",
        tabcontAddClass: "tabcont-on"
    }),
    new InterestSoliderNew({
        box: "#interest_v1",
        navs: "#interest_nav1 a",
        lists: ".home-v3",
        current: "current",
        prev: "#rotate_prev1",
        next: "#rotate-next1"
    }),
    new InterestSoliderNew({
        box: "#interest_v2",
        navs: "#interest_nav2 a",
        lists: ".home-v3",
        current: "current",
        prev: "#rotate_prev2",
        next: "#rotate-next2"
    }),
    new InterestSoliderNew({
        box: "#interest_v3",
        navs: "#interest_nav3 a",
        lists: ".home-v3",
        current: "current",
        prev: "#rotate_prev3",
        next: "#rotate-next3"
    }),
    new InterestSoliderNew({
        box: "#interest_v4",
        lists: "li",
        prev: "#rotate_prev4",
        next: "#rotate-next4",
        autoloop: !1,
        eventtype: "click"
    }),
    $("#house_msg li").live("click", 
    function(a) {
        $("#house_img").attr("src", $(this).attr("data-img")),
        $("#house_link").attr("href", $(this).attr("data-link")),
        $("#house_name").text($(this).attr("data-name")),
        $("#house_info").text($(this).attr("data-info")),
        $("#house_price").text($(this).attr("data-price")),
        $("#hagent-msg").css("background-position", "0px " + ($(this).offset().top - $("#hagent-msg").offset().top) + "px")
    }),
    $("#house_msg li").live("mouseover", 
    function() {
        $(this).addClass("hovercurrent")
    }).live("mouseout", 
    function() {
        $(this).removeClass("hovercurrent")
    });
    var b = [],
    c = !0,
    d = function() {
        $.ajax({
            url: "http://ajax.taofang.com/indexRecommend/recommend.do?count=6&format=json&category=0&cityCode=bj&callback=?",
            cache: !1,
            data: {},
            dataType: "jsonp",
            success: function(a) {
                console.log(a);
                if (a.length == 0 || a == null) return ! 1;
                var d = [];
                if (b.length == 0 && a.length == 1) $.each(a, 
                function(a, b) {
                    d.push(['<li class="c displaynpne" data-img="' + b.house.photoBrowse + '" data-name="' + b.house.estateName + '" data-info="' + b.house.area + "㎡" + "   " + b.house.flatType + "   " + b.house.completion + "年建" + '" >', '<span class="msg-dot"></span>', '<dl class="c">', "<dt>", '<a href="###" class="aimg">', '<img src="' + b.house.photoTiny + '"/>', "</a>", "</dt>", "<dd>", '<p class="msg-title"><em>2</em>' + b.house.title + "</p>", '<p class="c">', '<span class="l gray">2</span>', '<span class="r link-B" ><a href="3">查看>></a></span>', "</p>", "</dd>", "</dl>", "</li>"].join(""))
                }),
                $("#house_msg").prepend(d.join("")),
                $("#house_msg").find(".displaynpne").slideDown(2e3);
                else {
                    $.each(a, 
                    function(a, c) {
                        b.push(c)
                    });
                    function e() {
                        if (b.length == 0) return c = !0,
                        !1;
                        var a = [];
                        a.push(['<li class="c displaynpne" data-img="' + b[0].house.photoBrowse + '" data-name="' + b[0].house.estateName + '" data-info="' + b[0].house.area + "㎡" + "   " + b[0].house.flatType + "   " + b[0].house.completion + "年建" + '" >', '<span class="msg-dot"></span>', '<dl class="c">', "<dt>", '<a href="###" class="aimg">', '<img src="' + b[0].house.photoTiny + '"/>', "</a>", "</dt>", "<dd>", '<p class="msg-title"><em></em>' + b[0].house.title + "</p>", '<p class="c">', '<span class="l gray">2</span>', '<span class="r link-B" ><a href="3">查看>></a></span>', "</p>", "</dd>", "</dl>", "</li>"].join("")),
                        $("#house_msg").prepend(a.join("")),
                        $("#house_msg").find(".displaynpne").slideDown(2e3),
                        b.shift(),
                        window.setTimeout(function() {
                            e()
                        },
                        3e3)
                    }
                    b.length != 0 && c && (e(), c = !1)
                }
            }
        }),
        window.setTimeout(function() {
            d()
        },
        3e4)
    },
    e = function() {
        var a = $("#house_msg li").last();
        $("#house_msg").prepend(a),
        $("#house_msg").css("top", -a.height()),
        $("#house_msg").animate({
            top: 0
        },
        {
            duration: 1e3,
            complete: function() {
                var a = $("#hagent-msg").css("backgroundPosition"),
                b = /(\d+)(px|%)$/g.exec(a);
                switch (b[1]) {
                case "0":
                    $("#house_msg").children(":first").trigger("click");
                    break;
                case "65":
                    $("#house_msg").children().eq(1).trigger("click");
                    break;
                case "130":
                    $("#house_msg").children().eq(2).trigger("click");
                    break;
                case "195":
                    $("#house_msg").children().eq(3).trigger("click")
                }
            }
        }),
        window.setTimeout(function() {
            e()
        },
        8e3)
    };
    e(),
    $("a[href='###'],.nav-list a").attr("target", "_self"),
    $(".mkeys dt").click(function() {
        $(this).hasClass("dot-red") && ($(".mkeys").addClass("mkeys-on"), $(this).siblings("dd").show())
    }),
    $(".mkeys .mkey-foot a").click(function() {
        $(this).parent().parent().removeClass("mkeys-on")
    }),
    $("#selector_list li").click(function() {
        $("#selector_label").text($(this).children("a").text())
    }),
    $("#selector_list li a").hover(function() {
        $(this).toggleClass("on")
    }),
    $(".subjece-box .Simgs dl").hover(function() {
        $(this).toggleClass("on")
    }),
    $(".subjece-box .Limg ").find("a").hover(function() {
        $(this).children("label").removeClass("opacity-bgL").addClass(" opacity-bgG")
    },
    function() {
        $(this).children("label").removeClass("opacity-bgG").addClass(" opacity-bgL")
    }),
    $(".newhouse-rent .nh-box").hover(function() {
        $(this).toggleClass("nh-box-on")
    }),
    $(".newhouse-sell .nh-box").hover(function() {
        $(this).toggleClass("nh-box-on")
    }),
    $(".house-Ranking dt").hover(function() {
        $(this).parent().addClass("num-on"),
        $(this).parent().siblings("dl").removeClass("num-on")
    }),
    $(".buy-forum .left-box  dl").hover(function() {
        $(this).toggleClass("on")
    }),
    $(".buy-forum .mb-forum-b  li").hover(function() {
        $(this).toggleClass("on")
    }),
    $(".buy-forum .right-box  dl:even").addClass("on"),
    $(".bforum-focus ").hover(function() {
        $(this).addClass("current"),
        $(this).find("label").removeClass("opacity-bgL").addClass("opacity-bgG")
    },
    function() {
        $(this).removeClass("current"),
        $(this).find("label").removeClass("opacity-bgG").addClass("opacity-bgL")
    });
    var f = $(".sagent-box li").size(),
    g = f * 210,
    h = $(".sagent-box ul").css("left"),
    i = 210 - g,
    j = $("#agent_num .anum_b").text(f);
    $(".sagent-box ul").css("width", g),
    $(".star-agent .rotate-prev").click(function() {
        n()
    }),
    $(".star-agent .rotate-next").click(function() {
        m()
    })
});