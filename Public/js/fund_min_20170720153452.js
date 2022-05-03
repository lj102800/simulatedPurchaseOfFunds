! function (a) {
    a.fn.slide = function (b) {
        return a.fn.slide.defaults = {
            type: "slide",
            effect: "fade",
            autoPlay: !1,
            delayTime: 500,
            interTime: 2500,
            triggerTime: 150,
            defaultIndex: 0,
            titCell: ".hd li",
            mainCell: ".bd",
            targetCell: null,
            trigger: "mouseover",
            scroll: 1,
            vis: 1,
            titOnClassName: "on",
            autoPage: !1,
            prevCell: ".prev",
            nextCell: ".next",
            pageStateCell: ".pageState",
            opp: !1,
            pnLoop: !0,
            easing: "swing",
            startFun: null,
            endFun: null,
            switchLoad: null,
            playStateCell: ".playState",
            mouseOverStop: !0,
            defaultPlay: !0,
            returnDefault: !1
        }, this.each(function () {
            var d = a.extend({}, a.fn.slide.defaults, b),
                n = a(this),
                o = d.effect,
                t = a(d.prevCell, n),
                u = a(d.nextCell, n),
                jb = a(d.pageStateCell, n),
                F = a(d.playStateCell, n),
                l = a(d.titCell, n),
                f = l.size(),
                e = a(d.mainCell, n),
                g = e.children().size(),
                w = d.switchLoad,
                A = a(d.targetCell, n),
                c = parseInt(d.defaultIndex),
                j = parseInt(d.delayTime),
                T = parseInt(d.interTime);
            parseInt(d.triggerTime);
            var r, h = parseInt(d.scroll),
                p = parseInt(d.vis),
                kb = "false" == d.autoPlay || 0 == d.autoPlay ? !1 : !0,
                X = "false" == d.opp || 0 == d.opp ? !1 : !0,
                lb = "false" == d.autoPage || 0 == d.autoPage ? !1 : !0,
                L = "false" == d.pnLoop || 0 == d.pnLoop ? !1 : !0,
                Y = "false" == d.mouseOverStop || 0 == d.mouseOverStop ? !1 : !0,
                D = "false" == d.defaultPlay || 0 == d.defaultPlay ? !1 : !0,
                cb = "false" == d.returnDefault || 0 == d.returnDefault ? !1 : !0,
                m = 0,
                k = 0,
                E = 0,
                I = 0,
                q = d.easing,
                z = null,
                J = null,
                K = null,
                v = d.titOnClassName,
                db = l.index(n.find("." + v)),
                S = c = -1 == db ? c : db,
                eb = c,
                B = c,
                i = g >= p ? 0 != g % h ? g % h : h : 0,
                x = "leftMarquee" == o || "topMarquee" == o ? !0 : !1,
                fb = function () {
                    a.isFunction(d.startFun) && d.startFun(c, f, n, a(d.titCell, n), e, A, t, u)
                },
                s = function () {
                    a.isFunction(d.endFun) && d.endFun(c, f, n, a(d.titCell, n), e, A, t, u)
                },
                U = function () {
                    l.removeClass(v), D && l.eq(eb).addClass(v)
                };
            if ("menu" == d.type) return D && l.removeClass(v).eq(c).addClass(v), l.hover(function () {
                r = a(this).find(d.targetCell);
                var b = l.index(a(this));
                J = setTimeout(function () {
                    switch (c = b, l.removeClass(v).eq(c).addClass(v), fb(), o) {
                    case "fade":
                        r.stop(!0, !0).animate({
                            opacity: "show"
                        }, j, q, s);
                        break;
                    case "slideDown":
                        r.stop(!0, !0).animate({
                            height: "show"
                        }, j, q, s)
                    }
                }, d.triggerTime)
            }, function () {
                switch (clearTimeout(J), o) {
                case "fade":
                    r.animate({
                        opacity: "hide"
                    }, j, q);
                    break;
                case "slideDown":
                    r.animate({
                        height: "hide"
                    }, j, q)
                }
            }), cb && n.hover(function () {
                clearTimeout(K)
            }, function () {
                K = setTimeout(U, j)
            }), void 0;
            if (0 == f && (f = g), x && (f = 2), lb) {
                if (g >= p)
                    if ("leftLoop" == o || "topLoop" == o) f = 0 != g % h ? (0 ^ g / h) + 1 : g / h;
                    else {
                        var V = g - p;
                        f = 1 + parseInt(0 != V % h ? V / h + 1 : V / h), 0 >= f && (f = 1)
                    } else f = 1;
                l.html("");
                var W = "";
                if (1 == d.autoPage || "true" == d.autoPage)
                    for (var C = 0; f > C; C++) W += "<li>" + (C + 1) + "</li>";
                else
                    for (var C = 0; f > C; C++) W += d.autoPage.replace("$", C + 1);
                l.html(W);
                var l = l.children()
            }
            if (g >= p) {
                e.children().each(function () {
                    a(this).width() > E && (E = a(this).width(), k = a(this).outerWidth(!0)), a(this).height() > I && (I = a(this).height(), m = a(this).outerHeight(!0))
                });
                var gb = e.children(),
                    hb = function () {
                        for (var a = 0; p > a; a++) gb.eq(a).clone().addClass("clone").appendTo(e);
                        for (var a = 0; i > a; a++) gb.eq(g - a - 1).clone().addClass("clone").prependTo(e)
                    };
                switch (o) {
                case "fold":
                    e.css({
                        position: "relative",
                        width: k,
                        height: m
                    }).children().css({
                        position: "absolute",
                        width: E,
                        left: 0,
                        top: 0,
                        display: "none"
                    });
                    break;
                case "top":
                    e.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:' + p * m + 'px"></div>').css({
                        top: -(c * h) * m,
                        position: "relative",
                        padding: "0",
                        margin: "0"
                    }).children().css({
                        height: I
                    });
                    break;
                case "left":
                    e.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:' + p * k + 'px"></div>').css({
                        width: g * k,
                        left: -(c * h) * k,
                        position: "relative",
                        overflow: "hidden",
                        padding: "0",
                        margin: "0"
                    }).children().css({
                        "float": "left",
                        width: E
                    });
                    break;
                case "leftLoop":
                case "leftMarquee":
                    hb(), e.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:' + p * k + 'px"></div>').css({
                        width: (g + p + i) * k,
                        position: "relative",
                        overflow: "hidden",
                        padding: "0",
                        margin: "0",
                        left: -(i + c * h) * k
                    }).children().css({
                        "float": "left",
                        width: E
                    });
                    break;
                case "topLoop":
                case "topMarquee":
                    hb(), e.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:' + p * m + 'px"></div>').css({
                        height: (g + p + i) * m,
                        position: "relative",
                        padding: "0",
                        margin: "0",
                        top: -(i + c * h) * m
                    }).children().css({
                        height: I
                    })
                }
            }
            var R = function (a) {
                    var b = a * h;
                    return a == f ? (b = g) : -1 == a && 0 != g % h && (b = -g % h), b
                },
                ib = function (l) {
                    var b = function (c) {
                        for (var b = c; p + c > b; b++) l.eq(b).find("img[" + w + "]").each(function () {
                            var b = a(this);
                            if (b.attr("src", b.attr(w)).removeAttr(w), e.find(".clone")[0])
                                for (var d = e.children(), c = 0; c < d.size(); c++) d.eq(c).find("img[" + w + "]").each(function () {
                                    a(this).attr(w) == b.attr("src") && a(this).attr("src", a(this).attr(w)).removeAttr(w)
                                })
                        })
                    };
                    switch (o) {
                    case "fade":
                    case "fold":
                    case "top":
                    case "left":
                    case "slideDown":
                        b(c * h);
                        break;
                    case "leftLoop":
                    case "topLoop":
                        b(i + R(B));
                        break;
                    case "leftMarquee":
                    case "topMarquee":
                        var d = "leftMarquee" == o ? e.css("left").replace("px", "") : e.css("top").replace("px", ""),
                            f = "leftMarquee" == o ? k : m,
                            g = i;
                        if (0 != d % f) {
                            var j = Math.abs(0 ^ d / f);
                            g = 1 == c ? i + j : i + j - 1
                        }
                        b(g)
                    }
                },
                y = function (n) {
                    if (!D || S != c || n || x) {
                        if (x ? c >= 1 ? (c = 1) : 0 >= c && (c = 0) : (B = c, c >= f ? (c = 0) : 0 > c && (c = f - 1)), fb(), null != w && ib(e.children()), A[0] && (r = A.eq(c), null != w && ib(A), "slideDown" == o ? (A.not(r).stop(!0, !0).slideUp(j), r.slideDown(j, q, function () {
                            e[0] || s()
                        })) : (A.not(r).stop(!0, !0).hide(), r.animate({
                            opacity: "show"
                        }, j, function () {
                            e[0] || s()
                        }))), g >= p) switch (o) {
                        case "fade":
                            e.children().stop(!0, !0).eq(c).animate({
                                opacity: "show"
                            }, j, q, function () {
                                s()
                            }).siblings().hide();
                            break;
                        case "fold":
                            e.children().stop(!0, !0).eq(c).animate({
                                opacity: "show"
                            }, j, q, function () {
                                s()
                            }).siblings().animate({
                                opacity: "hide"
                            }, j, q);
                            break;
                        case "top":
                            e.stop(!0, !1).animate({
                                top: -c * h * m
                            }, j, q, function () {
                                s()
                            });
                            break;
                        case "left":
                            e.stop(!0, !1).animate({
                                left: -c * h * k
                            }, j, q, function () {
                                s()
                            });
                            break;
                        case "leftLoop":
                            var a = B;
                            e.stop(!0, !0).animate({
                                left: -(R(B) + i) * k
                            }, j, q, function () {
                                -1 >= a ? e.css("left", -(i + (f - 1) * h) * k) : a >= f && e.css("left", -i * k), s()
                            });
                            break;
                        case "topLoop":
                            var a = B;
                            e.stop(!0, !0).animate({
                                top: -(R(B) + i) * m
                            }, j, q, function () {
                                -1 >= a ? e.css("top", -(i + (f - 1) * h) * m) : a >= f && e.css("top", -i * m), s()
                            });
                            break;
                        case "leftMarquee":
                            var b = e.css("left").replace("px", "");
                            0 == c ? e.animate({
                                left: ++b
                            }, 0, function () {
                                e.css("left").replace("px", "") >= 0 && e.css("left", -g * k)
                            }) : e.animate({
                                left: --b
                            }, 0, function () {
                                e.css("left").replace("px", "") <= -(g + i) * k && e.css("left", -i * k)
                            });
                            break;
                        case "topMarquee":
                            var d = e.css("top").replace("px", "");
                            0 == c ? e.animate({
                                top: ++d
                            }, 0, function () {
                                e.css("top").replace("px", "") >= 0 && e.css("top", -g * m)
                            }) : e.animate({
                                top: --d
                            }, 0, function () {
                                e.css("top").replace("px", "") <= -(g + i) * m && e.css("top", -i * m)
                            })
                        }
                        l.removeClass(v).eq(c).addClass(v), S = c, L || (u.removeClass("nextStop"), t.removeClass("prevStop"), 0 == c && t.addClass("prevStop"), c == f - 1 && u.addClass("nextStop")), jb.html("<span>" + (c + 1) + "</span>/" + f)
                    }
                };
            D && y(!0), cb && n.hover(function () {
                clearTimeout(K)
            }, function () {
                K = setTimeout(function () {
                    c = eb, D ? y() : "slideDown" == o ? r.slideUp(j, U) : r.animate({
                        opacity: "hide"
                    }, j, U), S = c
                }, 300)
            });
            var M = function (a) {
                    z = setInterval(function () {
                        X ? c-- : c++, y()
                    }, a ? a : T)
                },
                G = function (a) {
                    z = setInterval(y, a ? a : T)
                },
                H = function () {
                    Y || (clearInterval(z), M())
                },
                N = function () {
                    (L || c != f - 1) && (c++, y(), x || H())
                },
                O = function () {
                    (L || 0 != c) && (c--, y(), x || H())
                },
                P = function () {
                    clearInterval(z), x ? G() : M(), F.removeClass("pauseState")
                },
                Q = function () {
                    clearInterval(z), F.addClass("pauseState")
                };
            if (kb ? x ? (X ? c-- : c++, G(), Y && e.hover(Q, P)) : (M(), Y && n.hover(Q, P)) : (x && (X ? c-- : c++), F.addClass("pauseState")), F.click(function () {
                F.hasClass("pauseState") ? P() : Q()
            }), "mouseover" == d.trigger ? l.hover(function () {
                var a = l.index(this);
                J = setTimeout(function () {
                    c = a, y(), H()
                }, d.triggerTime)
            }, function () {
                clearTimeout(J)
            }) : l.click(function () {
                c = l.index(this), y(), H()
            }), x) {
                if (u.mousedown(N), t.mousedown(O), L) {
                    var Z, ab = function () {
                            Z = setTimeout(function () {
                                clearInterval(z), G(0 ^ T / 10)
                            }, 150)
                        },
                        bb = function () {
                            clearTimeout(Z), clearInterval(z), G()
                        };
                    u.mousedown(ab), u.mouseup(bb), t.mousedown(ab), t.mouseup(bb)
                }
                "mouseover" == d.trigger && (u.hover(N, function () {}), t.hover(O, function () {}))
            } else u.click(N), t.click(O)
        })
    }
}(jQuery), jQuery.easing.jswing = jQuery.easing.swing, jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function (a, b, c, d, e) {
        return jQuery.easing[jQuery.easing.def](a, b, c, d, e)
    }, easeInQuad: function (e, a, b, c, d) {
        return c * (a /= d) * a + b
    }, easeOutQuad: function (e, a, b, c, d) {
        return -c * (a /= d) * (a - 2) + b
    }, easeInOutQuad: function (e, a, b, c, d) {
        return (a /= d / 2) < 1 ? c / 2 * a * a + b : -c / 2 * (--a * (a - 2) - 1) + b
    }, easeInCubic: function (e, a, b, c, d) {
        return c * (a /= d) * a * a + b
    }, easeOutCubic: function (e, a, b, c, d) {
        return c * ((a = a / d - 1) * a * a + 1) + b
    }, easeInOutCubic: function (e, a, b, c, d) {
        return (a /= d / 2) < 1 ? c / 2 * a * a * a + b : c / 2 * ((a -= 2) * a * a + 2) + b
    }, easeInQuart: function (e, a, b, c, d) {
        return c * (a /= d) * a * a * a + b
    }, easeOutQuart: function (e, a, b, c, d) {
        return -c * ((a = a / d - 1) * a * a * a - 1) + b
    }, easeInOutQuart: function (e, a, b, c, d) {
        return (a /= d / 2) < 1 ? c / 2 * a * a * a * a + b : -c / 2 * ((a -= 2) * a * a * a - 2) + b
    }, easeInQuint: function (e, a, b, c, d) {
        return c * (a /= d) * a * a * a * a + b
    }, easeOutQuint: function (e, a, b, c, d) {
        return c * ((a = a / d - 1) * a * a * a * a + 1) + b
    }, easeInOutQuint: function (e, a, b, c, d) {
        return (a /= d / 2) < 1 ? c / 2 * a * a * a * a * a + b : c / 2 * ((a -= 2) * a * a * a * a + 2) + b
    }, easeInSine: function (e, b, c, a, d) {
        return -a * Math.cos(b / d * (Math.PI / 2)) + a + c
    }, easeOutSine: function (e, a, b, c, d) {
        return c * Math.sin(a / d * (Math.PI / 2)) + b
    }, easeInOutSine: function (e, a, b, c, d) {
        return -c / 2 * (Math.cos(Math.PI * a / d) - 1) + b
    }, easeInExpo: function (e, a, b, c, d) {
        return 0 == a ? b : c * Math.pow(2, 10 * (a / d - 1)) + b
    }, easeOutExpo: function (e, a, b, c, d) {
        return a == d ? b + c : c * (-Math.pow(2, -10 * a / d) + 1) + b
    }, easeInOutExpo: function (e, a, b, c, d) {
        return 0 == a ? b : a == d ? b + c : (a /= d / 2) < 1 ? c / 2 * Math.pow(2, 10 * (a - 1)) + b : c / 2 * (-Math.pow(2, -10 * --a) + 2) + b
    }, easeInCirc: function (e, a, b, c, d) {
        return -c * (Math.sqrt(1 - (a /= d) * a) - 1) + b
    }, easeOutCirc: function (e, a, b, c, d) {
        return c * Math.sqrt(1 - (a = a / d - 1) * a) + b
    }, easeInOutCirc: function (e, a, b, c, d) {
        return (a /= d / 2) < 1 ? -c / 2 * (Math.sqrt(1 - a * a) - 1) + b : c / 2 * (Math.sqrt(1 - (a -= 2) * a) + 1) + b
    }, easeInElastic: function (h, c, e, a, f) {
        var g = 1.70158,
            b = 0,
            d = a;
        if (0 == c) return e;
        if (1 == (c /= f)) return e + a;
        if (b || (b = .3 * f), d < Math.abs(a)) {
            d = a;
            var g = b / 4
        } else var g = b / (2 * Math.PI) * Math.asin(a / d);
        return -(d * Math.pow(2, 10 * (c -= 1)) * Math.sin((c * f - g) * 2 * Math.PI / b)) + e
    }, easeOutElastic: function (h, c, e, a, f) {
        var g = 1.70158,
            b = 0,
            d = a;
        if (0 == c) return e;
        if (1 == (c /= f)) return e + a;
        if (b || (b = .3 * f), d < Math.abs(a)) {
            d = a;
            var g = b / 4
        } else var g = b / (2 * Math.PI) * Math.asin(a / d);
        return d * Math.pow(2, -10 * c) * Math.sin((c * f - g) * 2 * Math.PI / b) + a + e
    }, easeInOutElastic: function (h, a, e, b, f) {
        var g = 1.70158,
            c = 0,
            d = b;
        if (0 == a) return e;
        if (2 == (a /= f / 2)) return e + b;
        if (c || (c = f * .3 * 1.5), d < Math.abs(b)) {
            d = b;
            var g = c / 4
        } else var g = c / (2 * Math.PI) * Math.asin(b / d);
        return 1 > a ? -.5 * d * Math.pow(2, 10 * (a -= 1)) * Math.sin((a * f - g) * 2 * Math.PI / c) + e : .5 * d * Math.pow(2, -10 * (a -= 1)) * Math.sin((a * f - g) * 2 * Math.PI / c) + b + e
    }, easeInBack: function (f, b, c, d, e, a) {
        return void 0 == a && (a = 1.70158), d * (b /= e) * b * ((a + 1) * b - a) + c
    }, easeOutBack: function (f, a, c, d, e, b) {
        return void 0 == b && (b = 1.70158), d * ((a = a / e - 1) * a * ((b + 1) * a + b) + 1) + c
    }, easeInOutBack: function (f, a, c, d, e, b) {
        return void 0 == b && (b = 1.70158), (a /= e / 2) < 1 ? d / 2 * a * a * (((b *= 1.525) + 1) * a - b) + c : d / 2 * ((a -= 2) * a * (((b *= 1.525) + 1) * a + b) + 2) + c
    }, easeInBounce: function (c, d, e, a, b) {
        return a - jQuery.easing.easeOutBounce(c, b - d, 0, a, b) + e
    }, easeOutBounce: function (e, a, b, c, d) {
        return (a /= d) < 1 / 2.75 ? c * 7.5625 * a * a + b : 2 / 2.75 > a ? c * (7.5625 * (a -= 1.5 / 2.75) * a + .75) + b : 2.5 / 2.75 > a ? c * (7.5625 * (a -= 2.25 / 2.75) * a + .9375) + b : c * (7.5625 * (a -= 2.625 / 2.75) * a + .984375) + b
    }, easeInOutBounce: function (d, b, e, c, a) {
        return a / 2 > b ? .5 * jQuery.easing.easeInBounce(d, 2 * b, 0, c, a) + e : .5 * jQuery.easing.easeOutBounce(d, 2 * b - a, 0, c, a) + .5 * c + e
    }
});
(function (a) {
    a("button, input:submit, input:button, a").on("focus", function () {
        this.blur()
    });
    a(".ui-table-hover tr").hover(function () {
        a(this).addClass("ui-hover")
    }, function () {
        a(this).removeClass("ui-hover")
    });
    a("button.ui-btn, input.ui-btn").hover(function () {
        var c = a(this).attr("class"),
            b = c.match(/(ui-btn-)(orange|blue|gray|white|pink)(-\w+)?/ig);
        if (!b) return;
        a(this).addClass(b[0] + "-hover")
    }, function () {
        var c = a(this).attr("class"),
            b = c.match(/(ui-btn-)(orange|blue|gray|white|pink)(-\w+)?/ig);
        if (!b) return;
        a(this).removeClass(b[0] + "-hover")
    });
    a(".ui-input").focus(function () {
        a(this).addClass("ui-input-focus")
    }).blur(function () {
        a(this).removeClass("ui-input-focus")
    });
    document.execCommand("BackgroundImageCache", false, true)
})(window.jQuery);
(function () {
    var a, e = function () {},
        c = ["assert", "clear", "count", "debug", "dir", "dirxml", "error", "exception", "group", "groupCollapsed", "groupEnd", "info", "log", "markTimeline", "profile", "profileEnd", "table", "time", "timeEnd", "timeline", "timelineEnd", "timeStamp", "trace", "warn"],
        d = c.length,
        b = window.console = window.console || {};
    while (d--) {
        a = c[d];
        if (!b[a]) b[a] = e
    }
})();
(function (a) {
    var b = function (c, b) {
        var a = document.createElement("script");
        a.setAttribute("type", "text/javascript");
        a.setAttribute("src", c);
        document.getElementsByTagName("head")[0].appendChild(a);
        if (a.addEventListener) a.onload = function () {
            a.parentNode.removeChild(a);
            b && b()
        };
        else if (a.readyState) a.onreadystatechange = function () {
            if (a.readyState == "loaded" || a.readyState == "complete") {
                a.onreadystatechange = null;
                a.parentNode.removeChild(a);
                b && b()
            }
        };
        else a.parentNode.removeChild(a)
    };
    a("[data-href]").on("click", function (e) {
        var b = a(e.target),
            c = b[0].tagName.toLowerCase();
        if (c === "a") return;
        var d = a(this).data("href");
        window.open(d, "_blank")
    })
})(window.jQuery);
var JsLoader, login, customerInfo;
(function (a) {
    JsLoader = function (c, b) {
        var a = document.createElement("script");
        a.setAttribute("type", "text/javascript");
        a.setAttribute("charset", "utf-8");
        a.setAttribute("src", c);
        document.getElementsByTagName("head")[0].appendChild(a);
        if (a.addEventListener) a.onload = function () {
            a.parentNode.removeChild(a);
            b && b()
        };
        else if (a.readyState) a.onreadystatechange = function () {
            if (a.readyState == "loaded" || a.readyState == "complete") {
                a.onreadystatechange = null;
                a.parentNode.removeChild(a);
                b && b()
            }
        };
        else a.parentNode.removeChild(a)
    };
    var b = function (a, b) {
        b.replaceURL = function (a, b) {
            var c = (new Date).getTime();
            a = a.replace(/{random}/g, c);
            return a.replace(/{fcode}/g, b)
        };
        b.hold4 = function (a) {
            return !a ? "--" : parseFloat(a).toFixed(4)
        };
        b.hold2 = function (a) {
            return !a ? "--" : parseFloat(a).toFixed(2)
        };
        b.hold2percent = function (a) {
            return !a ? "--" : parseFloat(a).toFixed(2) + "%"
        };
        b.hold4percent = function (a) {
            return !a ? "--" : parseFloat(a).toFixed(4) + "%"
        };
        b.ifNull = function (a) {
            return !a ? "--" : a
        };
        b.dealTip = function (c, a, b) {
            return !a ? "--" : '<a href="http://fund.eastmoney.com/f10/jjfl_' + b + '.html">' + a + "</a>"
        };
        b.isBuy = function (b, c) {
            var a = "",
                d = this;
            switch (b) {
            case "1":
            case "3":
            case "8":
            case "9":
                a = "<a class='ui-btn ui-btn-xs ui-btn-orange' href='https://trade.1234567.com.cn/FundtradePage/default2.aspx?fc=" + c + "'>购买</a>";
                break;
            case "2":
                a = "<a class='ui-btn ui-btn-xs ui-btn-orange' href='https://trade.1234567.com.cn/FundTradePage/default.aspx?tbtbb=1&fc=" + c + "'>购买</a>";
                break;
            default:
                a = "<a class='ui-btn ui-btn-xs ui-btn-gray' title='" + d.getUnbuyState(b) + "'>购买</a>"
            }
            return a
        };
        b.getUnbuyState = function (b) {
            var a = "";
            switch (b) {
            case "1":
                a = "正常开放";
                break;
            case "2":
                a = "认购时期";
                break;
            case "3":
                a = "停止赎回";
                break;
            case "4":
                a = "停止申购";
                break;
            case "5":
                a = "封闭期";
                break;
            case "6":
                a = "停止交易";
                break;
            case "7":
                a = "基金终止";
                break;
            case "8":
                a = "权益登记";
                break;
            case "9":
                a = "红利发放";
                break;
            case "10":
                a = "发行失败";
                break;
            default:
                a = "您所选购的基金暂未开通购买"
            }
            return a
        };
        b.red_green = function (a) {
            a = parseFloat(a);
            return a > 0 ? "ui-table-up" : a < 0 ? "ui-table-down" : ""
        };
        b.addFavor = function (b, a) {
            try {
                window.external.addFavorite(b || window.location.href, a || window.document.title)
            } catch (c) {
                try {
                    window.sidebar.addPanel(b || window.document.title, a || window.location, "")
                } catch (c) {
                    alert("加入收藏失败，请使用Ctrl+D进行添加")
                }
            }
        };
        b.setHome = function (a) {
            try {
                a.style.behavior = "url(#default#homepage)";
                a.setHomePage(window.location)
            } catch (c) {
                if (window.netscape) {
                    try {
                        netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect")
                    } catch (c) {
                        alert("此操作被浏览器拒绝！请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为'true'")
                    }
                    var b = Components.classes["@mozilla.org/preferences-service;1"].getService(Components.interfaces.nsIPrefBranch);
                    b.setCharPref("browser.startup.homepage", window.location)
                }
            }
        };
        b.scrollLoad = function () {
            var d = a(window).height(),
                c = a(window).scrollTop(),
                b = a(".lazy");
            b.each(function () {
                var h = a(this).find("iframe");
                if (!!h.length) return;
                var i = a(this).offset().top;
                if (i - 200 > d + c) return;
                var e = a('<iframe frameborder="0" marginwidth="0" marginheight="0" scrolling="no"></iframe>'),
                    b = a(this).data("url"),
                    g = a(this).data("w"),
                    f = a(this).data("h");
                e.attr("width", g).attr("height", f).attr("src", b);
                a(this).html(e[0]);
                if ((document.referrer.indexOf("baidu") > -1 || document.referrer.indexOf("183.136.163.197") > -1) && a(this).attr("id") == "rightadvert") {
                    b = a(this).data("aldurl");
                    if (!b) b = a(this).data("url");
                    e.attr("width", g).attr("height", f).attr("src", b)
                } else e.attr("width", g).attr("height", f).attr("src", b);
                a(this).html(e[0])
            })
        };
        b.online = function () {
            var b = 800,
                a = 500,
                d = (window.screen.availHeight - 30 - a) / 2,
                c = (window.screen.availWidth - 10 - b) / 2;
            window.open("https://imonline.eastmoney.com/", "OnlineCustomerService", "height=" + a + ",innerHeight=" + a + ",width=" + b + ",innerWidth=" + b + ",top=" + d + ",left=" + c + ",toolbar=no,menubar=no,scrollbars=auto,resizeable=no,location=no,status=no")
        };
        b.gotoTop_onlineKF = function (h, i) {
            var c = a(h),
                e = 1841,
                f = 280,
                j = c.height(),
                d = a(i),
                g = 150;
            a(window).on("scroll", function () {
                var b = a(window).scrollTop();
                if (b > e) c.show();
                else c.hide();
                var h = a(window).height();
                if (!-[1] && !window.XMLHttpRequest) {
                    c.css({
                        top: b + f + "px"
                    });
                    d.css({
                        top: b + g + "px"
                    })
                }
            });
            c.on("click", function (b) {
                b.preventDefault();
                a("html,body").animate({
                    scrollTop: 0
                }, 700)
            });
            d.on("click", function (c) {
                if (!!a(c.target).attr("href")) return;
                b.online()
            });
            d.on("mouseenter", function (b) {
                b.stopPropagation();
                b.preventDefault();
                a(this).find(".onlineKF_main").show()
            }).on("mouseleave", function (b) {
                b.stopPropagation();
                b.preventDefault();
                a(this).find(".onlineKF_main").hide()
            })
        };
        return b
    }(a, window.public_model || {});
    login = {
        loadURL: "http://sso.1234567.com.cn/FundTradeLoginState.aspx",
        loadData: function () {
            var b = this;
            JsLoader(this.loadURL + "?v=" + (new Date).getTime(), function () {
                if (customer.CustomerNo || customer.CustomerName) {
                    a("#logoutTTJJ").removeClass("ui-hide").find(".CustomerName").html('您好，<a class="red noPadding" href="https://trade.1234567.com.cn/MyAssets/Default">' + customer.CustomerName + "</a>");
                    a("#loginTTJJ").addClass("ui-hide");
                    a("#logout").on("click", function () {
                        b.logout()
                    })
                } else a("#logout").off("click"); if (isHaveGz && Data_performanceEvaluation) {
                    var c = new definePerformanceEvaluation;
                    c.init(Data_performanceEvaluation, customer)
                }
            })
        }, isLogin: function () {
            JsLoader(this.loadURL + "?v=" + (new Date).getTime(), function () {
                alert(customer.CustomerNo);
                return customer.CustomerNo || customer.CustomerName
            })
        }, logout: function () {
            JsLoader(this.loadURL + "?t=logout", function () {
                a("#logoutTTJJ").addClass("ui-hide").find(".CustomerName").html("");
                a("#loginTTJJ").removeClass("ui-hide")
            })
        }, init: function () {
            this.loadData()
        }
    };
    a(document).ready(function () {
        a(".F_header .dropdown").on("mouseover", function () {
            a(this).addClass("open")
        }).on("mouseout", function () {
            a(this).removeClass("open")
        });
        a("#setHome,#foot_sethome").on("click", function () {
            b.setHome(this)
        });
        a("#addFavor").on("click", function () {
            b.addFavor("http://fund.eastmoney.com/", "天天基金网--东方财富网旗下基金平台")
        });
        a("#foot_setfavor,#favorPage").on("click", function () {
            b.addFavor()
        });
        a("#select_LX, #select_GS").on("change", function () {
            var c = a(this).find("option:selected").attr("value"),
                d = a(this).attr("id"),
                b = a("#selectBegin").attr("href");
            if (d === "select_LX") b = b.replace(/(ft)[a-zA-Z]{0,4};/, "$1" + c + ";");
            else if (d === "select_GS") b = b.replace(/(cp)\d{0,};/, "$1" + c + ";");
            a("#selectBegin").attr("href", b)
        }).trigger("change");
        a("#online").on("click", function () {
            b.online()
        });
        b.gotoTop_onlineKF("#gotoTop", "#onlineKF");
        a("#gotoGB").on("click", function () {
            var b = a("#search-input").val();
            if (!b) window.open("http://guba.eastmoney.com/", "_blank");
            else window.open("http://quote.eastmoney.com/search.html?stockcode=" + b + "&toba=1", "_blank")
        });
        a("#gotoZX").on("click", function () {
            var b = a("#search-input").val();
            if (!b) window.open("http://so.eastmoney.com/", "_blank");
            else window.open("http://so.eastmoney.com/News/s?KeyWord=" + b + "&m=0&t=1&s=1&f=1&p=0", "_blank")
        });
        var c = a("#tabBtn_yjpj");
        if (c && c != null) a("#tabBtn_yjpj").on("click", function () {
            if (isHaveGz && Data_performanceEvaluation) {
                var a = new definePerformanceEvaluation;
                a.init(Data_performanceEvaluation, customer)
            }
        });
        b.scrollLoad();
        a(window).on("scroll", function () {
            if (a(this).scrollTop() > 400) a("#gotoTop").show();
            else a("#gotoTop").hide();
            b.scrollLoad()
        })
    })
})(window.jQuery);
var definePerformanceEvaluation = function () {};
(function (a) {
    var I = function () {};
    I.prototype = {
        fmoney: function (a, b) {
            a = parseFloat(a);
            b = b > 0 && b <= 20 ? b : 2;
            a = parseFloat((a + "").replace(/[^\d\.-]/g, "")).toFixed(b) + "";
            var c = a.split(".")[0].split("").reverse(),
                d = a.split(".")[1];
            t = "";
            for (i = 0; i < c.length; i++) t += c[i] + ((i + 1) % 3 == 0 && i + 1 != c.length ? "," : "");
            if (a != "") return t.split("").reverse().join("") + "." + d
        }, formerMoney: function (i) {
            var i = new String(Math.round(i * 100)),
                h = "",
                j = "零壹贰叁肆伍陆柒捌玖",
                e = "万仟佰拾亿仟佰拾万仟佰拾元角分",
                d = i.length,
                g, f, b = 0,
                c;
            if (d > 11) return "超出计算范围";
            if (i == 0) {
                h = "零元整";
                return h
            }
            e = e.substr(e.length - d, d);
            for (var a = 0; a < d; a++) {
                c = parseInt(i.substr(a, 1), 10);
                if (a != d - 3 && a != d - 7 && a != d - 11 && a != d - 15)
                    if (c == 0) {
                        g = "";
                        f = "";
                        b = b + 1
                    } else if (c != 0 && b != 0) {
                    g = "零" + j.substr(c, 1);
                    f = e.substr(a, 1);
                    b = 0
                } else {
                    g = j.substr(c, 1);
                    f = e.substr(a, 1);
                    b = 0
                } else {
                    if (c != 0 && b != 0) {
                        g = "零" + j.substr(c, 1);
                        f = e.substr(a, 1);
                        b = 0
                    } else if (c != 0 && b == 0) {
                        g = j.substr(c, 1);
                        f = e.substr(a, 1);
                        b = 0
                    } else if (c == 0 && b >= 3) {
                        g = "";
                        f = "";
                        b = b + 1
                    } else {
                        g = "";
                        f = e.substr(a, 1);
                        b = b + 1
                    } if (a == d - 11 || a == d - 3) f = e.substr(a, 1)
                }
                h = h + g + f
            }
            if (c == 0) h = h + "整";
            return h
        }, clone: function (b) {
            for (var c = [], a = 0, d = b.length; a < d; a++) c.push(b[a]);
            return c
        }
    };
    var b = new I,
        x = function () {};
    x.prototype = {
        init: function (b) {
            this.containter = a("#BottomSwith");
            this.handleRefresh = a(b.r) || a("#switch");
            this.handleClose = a(b.c) || a(".sclose");
            this.containter.show();
            this.bindController()
        }, bindController: function () {
            var a = this;
            this.handleClose.on("click", function () {
                a.containter.hide()
            })
        }
    };
    var z = function () {};
    z.prototype = {
        init: function (a) {
            jQuery(a.s).slide(a)
        }
    };
    var G = function () {};
    G.prototype = {
        init: function () {
            var b = a(".merchandiseDetail").offset().top + a(".merchandiseDetail").height();
            a(window).scroll(function () {
                if (a("body").scrollTop() >= b || a(document).scrollTop() >= b) a("#fixedTop").show();
                else a("#fixedTop").hide()
            })
        }
    };
    var l = function () {};
    l.prototype = {
        init: function () {
            var c = a("#estimatedMap").find("img"),
                b = a(c).attr("src");
            a(".item_reload").on("click", function () {
                b && a(c).attr("src", b + "?v=" + Math.random())
            });
            setInterval(function () {
                var d = new Date;
                if (d.getDay() > 0 && d.getDay() < 6)
                    if (d.getHours() >= 9 && d.getHours() < 12) a(c).attr("src", b + "?v=" + Math.random());
                    else d.getHours() >= 13 && d.getHours() < 15 && a(c).attr("src", b + "?v=" + Math.random())
            }, 3e4)
        }
    };
    var E = function () {};
    E.prototype = {
        isIe678: function () {
            var a = navigator.appVersion;
            return a.search(/MSIE 6/i) != -1 ? "IE6" : a.search(/MSIE 7/i) != -1 ? "IE7" : a.search(/MSIE 8/i) != -1 ? "IE8" : false
        }, init: function (b) {
            var c = this,
                a;
            this.ieVersion = this.isIe678();
            for (a in b.task) switch (a) {
            case "ie6FixedRepair":
                c.ie6FixedRepair(b.task[a]);
                break;
            case "ie678FixedPlaceHolder":
                c.ie678FixedPlaceHolder(b.task[a])
            }
        }, ie6FixedRepair: function (c) {
            var d = this;
            if (this.ieVersion != "IE6") return;

            function b() {
                a(c.selector).css({
                    position: "absolute",
                    top: a(window).scrollTop() - 100,
                    left: 0,
                    width: a(window).width(),
                    height: a(window).height() + 200
                })
            }
            b();
            a(window).scroll(function () {
                a(c.selector).css({
                    top: a(window).scrollTop() - 100
                })
            });
            a(window).resize(function () {
                b()
            })
        }, ie678FixedPlaceHolder: function (b) {
            a(b.selector).each(function () {
                var b = a(this).attr("data-placeholder");
                a(this).addClass("placeholder").val(b).focus(function () {
                    a(this).removeClass("placeholder");
                    a(this).val() == b && a(this).val("")
                }).blur(function () {
                    a(this).val() == "" && a(this).addClass("placeholder").val(b)
                })
            })
        }
    };
    var A = function () {};
    A.prototype = {
        init: function () {
            this.close = a("#calculator-close");
            this.enter = a("#calculatorEnter");
            this.inp = a(".funCur-Money");
            this.result = a(".result-money");
            this.warp = a("#calculator-layer");
            this.warmTips = a(".MoneyInChinese");
            this.popInp = a("#moneyAmountTxt");
            this.downApp_canbuy = a("#downAppAtBuyWay");
            this.QRCode_canbuy = a("#downAppAtBuyWay_QRCode");
            this.downApp_cannotbuy = a("#downAppAtBuyWay02");
            this.QRCode_cannotbuy = a("#downAppAtBuyWay02_QRCode");
            this.calculatorAmount = a("#calculatorAmount");
            this.buyUrl = a("#buyNowStatic");
            this.dtUrl = a("#FixedInvestment");
            this.bindEvent();
            this.emptyState()
        }, commonCa: function (f, h, g) {
            var c = (parseFloat(g / 100) * h).toFixed(2),
                e = c < 0,
                d = "ui-color-red";
            if (e) {
                c = Math.abs(c);
                d = "ui-color-green"
            } else if (c == 0) d = "";
            a("#" + f).html("<span class='" + d + "'>" + (e ? "-" + b.fmoney(c) : b.fmoney(c)) + "元</span>")
        }, emptyState: function () {
            this.result.addClass("noresult").removeClass("hasresult").text("-- 元");
            this.warmTips.hide().empty()
        }, getApplyBuyMoney: function (p, e) {
            var b = p,
                o = "银行卡支付",
                a = {
                    buyFee: 0,
                    saveNum: 0,
                    rate: fund_Rate + "%"
                };
            if (!isNaN(b.toString()) && b > 0 && b != null && o != null)
                if (e == null || e.length == 0) {
                    a.buyFee = 0;
                    a.saveNum = 0
                } else
                    for (var i = 0; i < e.length; i++) {
                        var c = e[i],
                            k, l, j, h, d;
                        k = parseFloat(c.LOWERLIMIT);
                        l = parseFloat(c.UPPERLIMIT);
                        j = parseFloat(c.DISCOUNTCASH);
                        h = parseFloat(c.DISCOUNT);
                        d = parseFloat(c.RATE);
                        if (c.RATEUNIT == "%") a.rate = Math.round(d * 100 * h * 100) / 100 + "%";
                        else a.rate = "\t每笔" + d + c.RATEUNIT; if (b >= k && b <= l) {
                            if (d > 99) a.buyFee = d;
                            else {
                                var m = o == "活期宝支付" ? j : h,
                                    n = d,
                                    f = b - b / (n + 1);
                                f = Math.round(f * 100) / 100;
                                if (m == 1) {
                                    a.buyFee = f;
                                    a.saveNum = 0
                                } else {
                                    var g = b - b / (n * m + 1);
                                    g = Math.round(g * 100) / 100;
                                    a.buyFee = g;
                                    a.saveNum = Math.round((f - g) * 100) / 100
                                }
                            }
                            break
                        }
                    }
                return a
        }, resetBuyAndDtUrl: function (d) {
            var b = "https://trade.1234567.com.cn/buy",
                c = "https://trade.1234567.com.cn/buy";
            if (fundBuyStatus && "1,2,3,8,9".indexOf(fundBuyStatus) > -1) {
                if (fundBuyStatus == "2") b = b + "?busin=20&fc=" + sgCode + "&amount=" + d;
                else b = b + "?busin=22&fc=" + sgCode + "&amount=" + d;
                a(this.buyUrl).attr("href", b)
            }
            if (fundDtStatus && fundDtStatus == "true") {
                c = c + "?busin=39&fc=" + sgCode + "&amount=" + d;
                a(this.dtUrl).attr("href", c)
            }
        }, bindEvent: function () {
            var c = this;
            this.close.click(function () {
                c.warp.hide()
            });
            this.enter.click(function () {
                c.warp.show()
            });
            this.inp.keyup(function () {
                a(this).val(a(this).val().replace(/\D/g, ""));
                var d = a(this).val(),
                    e = "";
                if (d == "") {
                    c.emptyState();
                    return
                }
                var f = /^\d+(\.\d*)?$/.test(d);
                if (!f) e = "请输入非负数字";
                else e = b.formerMoney(d);
                c.warmTips.text(e).slideDown();
                if (f) {
                    d = d.split(".")[0].replace(new RegExp(/(,)/g), "");
                    syl_1n && c.commonCa("ca_syl_1n", d, syl_1n);
                    syl_6y && c.commonCa("ca_syl_6y", d, syl_6y);
                    syl_3y && c.commonCa("ca_syl_3y", d, syl_3y);
                    syl_1y && c.commonCa("ca_syl_1y", d, syl_1y)
                }
            });
            this.inp.blur(function () {
                var c = a(this).val().split(".")[0].replace(new RegExp(/(,)/g), "");
                b.fmoney(c) != "NaN.undefined" && a(this).val(b.fmoney(c))
            });
            this.inp.keydown(function (d) {
                var b = d.keyCode;
                if (b <= 57 && b >= 48 || b <= 105 && b >= 96 || b == 8) {
                    var c = a(this).val().split(".")[0].replace(new RegExp(/(,)/g), ""),
                        e = parseFloat(c);
                    return c.length >= 9 ? b == 8 ? true : false : true
                } else return false
            });
            this.popInp.blur(function () {
                var e = a(this).attr("data-placeholder");
                if (a(this).val() == "" || a(this).val() == e) {
                    a(this).addClass("placeholder").val(e);
                    c.calculatorAmount.addClass("visibility_hidden");
                    c.resetBuyAndDtUrl("");
                    return false
                }
                var d = a(this).val().split(".")[0].replace(new RegExp(/(,)/g), "");
                if (b.fmoney(d) != "NaN.undefined") {
                    if (d < parseFloat(fund_minsg)) {
                        c.calculatorAmount.removeClass("visibility_hidden");
                        c.calculatorAmount.html('<div class="minsg_err_icon"></div><div class="minsg_err"><span>单笔最低投资金额为：' + parseFloat(fund_minsg).toFixed(2) + "元</span></div>")
                    }
                    a(this).val(b.fmoney(d))
                } else d = "";
                c.resetBuyAndDtUrl(d)
            });
            this.popInp.on("keydown", function (d) {
                var b = d.keyCode;
                if (b <= 57 && b >= 48 || b <= 105 && b >= 96 || b == 8) {
                    var c = a(this).val().split(".")[0].replace(new RegExp(/(,)/g), ""),
                        e = parseFloat(c);
                    return c.length >= 9 ? b == 8 ? true : false : true
                } else return false
            });
            this.popInp.on("keyup", function () {
                var d = a(this).val().split(".")[0].replace(new RegExp(/(,)/g), "");
                if (!d || d.length == 0) d = 0;
                var e = parseFloat(d);
                if (fund_Rate)
                    if (fund_Rate <= 0) {
                        c.calculatorAmount.removeClass("visibility_hidden");
                        c.calculatorAmount.html('<span class="itemTit" style="margin-left:-60px">预计购买费用：免费</span>')
                    } else {
                        var b = c.getApplyBuyMoney(e, fundRateInfo);
                        c.calculatorAmount.html('<span class="itemTit" style="margin-left:-60px">预计购买费用：</span>' + b.buyFee.toFixed(2) + "元(" + (b.rate.indexOf("每笔") > -1 ? "" : "费率") + b.rate + (b.saveNum && b.saveNum > 0 ? '，节省<span style="color:#ff0000">' + b.saveNum.toFixed(2) + "</span>元" : "") + ")");
                        if (fundRateInfo && fundRateInfo[0] && fundRateInfo[0].LIMITUNIT == "年") c.calculatorAmount.addClass("visibility_hidden");
                        else c.calculatorAmount.removeClass("visibility_hidden")
                    }
            });
            this.downApp_canbuy.mouseover(function () {
                c.QRCode_canbuy.show()
            });
            this.downApp_canbuy.mouseout(function () {
                c.QRCode_canbuy.hide()
            });
            this.downApp_cannotbuy.mouseover(function () {
                c.QRCode_cannotbuy.show()
            });
            this.downApp_cannotbuy.mouseout(function () {
                c.QRCode_cannotbuy.hide()
            })
        }
    };
    var D = function () {};
    D.prototype = {
        init: function () {
            a(".infoTips").each(function () {
                window.tipsBubble = null;
                a(this).on("mouseover", function () {
                    clearInterval(tipsBubble);
                    a(".tipsBubble").hide();
                    a(this).find(".tipsBubble").show()
                });
                a(this).on("mouseout", function () {
                    var b = a(this);
                    tipsBubble = setTimeout(function () {
                        b.find(".tipsBubble").hide()
                    }, 300)
                })
            });
            a(".infoTips1").each(function () {
                window.tipsBubble = null;
                a(this).on("mouseover", function () {
                    clearInterval(tipsBubble);
                    a(".tipsBubble").hide();
                    a(this).find(".tipsBubble").show()
                });
                a(this).on("mouseout", function () {
                    var b = a(this);
                    tipsBubble = setTimeout(function () {
                        b.find(".tipsBubble").hide()
                    }, 300)
                })
            })
        }
    };
    var H = function () {};
    H.prototype = {
        init: function () {
            this.bindEvent()
        }, bindEvent: function () {
            a(".popTab").each(function () {
                var f = a(this),
                    c = a(this).find(".hd .tabBtn"),
                    b = a(this).parent().find(".titleItemActive02").length > 0 ? "titleItemActive02" : "titleItemActive",
                    d = a(this).find(".bd li");
                c.on("click", function () {
                    var e = a(this).index();
                    d.hide();
                    c.removeClass(b);
                    d.eq(e).show();
                    a(this).addClass(b)
                });
                var e = a(this).find(".hd .titleItems");
                a(e).on("click", function () {
                    var b = a(this).attr("data-href-more");
                    b && b.length > 0 && a(this).parent().find(".item_more").find("a").attr("href", b)
                })
            });
            var d = a(".themeFund").find(".hd .tabBtn"),
                e = a(".themeFund").find(".poptab_more");
            d.on("click", function () {
                e.attr("href", "http://fund.eastmoney.com/ztjj/" + a(this).attr("data-id") + "_themedetail.html?sort=SYL_Z&rs=GZD&sid=0#sort:SYL_Z:rs:GZD:TableSort:SYL_1N:sid:0")
            });
            var b = a(".IncreaseAmount").find(".hd .tabBtn"),
                c = a("#jdzfDate");
            b.on("click", function () {
                c.html(a(this).attr("data-date"))
            })
        }
    };
    var F = function () {};
    F.prototype = {
        init: function () {
            a(".jjywMore").on("click", function () {
                var b = a(this).attr("data-value");
                window.open("http://so.eastmoney.com/News/s?KeyWord=" + escape(b) + "&m=0&t=2&s=1&p=0")
            })
        }
    };
    var y = function () {};
    y.prototype = {
        init: function () {
            this.bindEvent()
        }, bindEvent: function () {
            a(".hd  .sel_more").each(function () {
                var b = a(this);
                a(b).on("click", function (c) {
                    a(".hd .sel_warp").show();
                    a(b).addClass("border");
                    c.stopPropagation();
                    c.preventDefault()
                })
            });
            var b = a(".rankInSimilarWrap").find(".bd li");
            a(".hd .sel_warp").find("a").each(function (d, c) {
                a(this).on("click", function (d) {
                    var e = a(this).index() + 3;
                    b.hide();
                    b.eq(e).show();
                    a(".hd .sel_warp").hide();
                    a(".hd  .sel_more").removeClass("border");
                    a(".hd .sel_more").text(a(c).text());
                    a(".rankInSimilarWrap .titleItemActive").removeClass("titleItemActive");
                    a(".hd  .sel_more").parent().addClass("titleItemActive");
                    d.stopPropagation();
                    d.preventDefault()
                })
            });
            a(".rankInSimilarWrap .tabBtn").each(function (c, b) {
                a(b).on("click", function () {
                    a(".hd  .sel_more").text("更多").parent().removeClass("titleItemActive")
                })
            });
            a("body").on("click", function () {
                a(".hd .sel_warp").hide();
                a(".hd  .sel_more").removeClass("border")
            })
        }
    };
    var r = function () {};
    r.prototype = {
        init: function (a) {
            Highcharts.setOptions(a)
        }
    };
    var f = function () {};
    f.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#fundSharesPositions").highcharts("StockChart", {
                credits: {
                    enabled: false
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: "股票仓位百分比: {point.y}%",
                    valueDecimals: 2
                },
                data: {
                    dateFormat: "YYYY-mm-dd"
                },
                title: {
                    text: fS_name + "[" + fS_code + "] 股票仓位测算图",
                    style: {
                        color: "#333",
                        fontSize: "12px"
                    }
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value.toFixed(0) + "%"
                        }
                    },
                    opposite: false
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                navigator: {
                    enabled: false
                },
                rangeSelector: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        }
                    }
                },
                series: [{
                    type: "line",
                    name: "股票仓位百分比",
                    data: b
                }],
                lang: {
                    noData: "暂无数据"
                },
                noData: {
                    style: {
                        fontSize: "12px",
                        color: "#808080",
                        fontWeight: "100"
                    }
                }
            })
        }
    };
    var v = function () {};
    v.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#netWorthTrend").highcharts("StockChart", {
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: "<p>单位净值：{point.y:.4f}元</p>"
                },
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -120,
                        x: 162
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                rangeSelector: {
                    inputEnabled: false,
                    buttonTheme: {
                        fill: "none",
                        stroke: "none",
                        "stroke-width": 0,
                        r: 0,
                        width: 33,
                        style: {
                            color: "#333",
                            fontWeight: "normal"
                        },
                        states: {
                            hover: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            },
                            select: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            }
                        }
                    },
                    labelStyle: {
                        color: "#333",
                        fontWeight: "bold"
                    },
                    buttons: [{
                        type: "month",
                        count: 1,
                        text: "1月"
                    }, {
                        type: "month",
                        count: 3,
                        text: "3月"
                    }, {
                        type: "month",
                        count: 6,
                        text: "6月"
                    }, {
                        type: "year",
                        count: 1,
                        text: "1年"
                    }, {
                        type: "year",
                        count: 3,
                        text: "3年"
                    }, {
                        type: "year",
                        count: 5,
                        text: "5年"
                    }, {
                        type: "ytd",
                        text: "今年来"
                    }, {
                        type: "all",
                        text: "最大"
                    }],
                    selected: 1
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value.toFixed(2)
                        }
                    },
                    tickPixelInterval: 50,
                    opposite: false,
                    reversed: false
                },
                title: {
                    text: ""
                },
                xAxis: {
                    endOnTick: true,
                    maxPadding: .05,
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null,
                        dataGrouping: {
                            enabled: false,
                            approximation: "open",
                            units: [
                                ["day", [1]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }
                },
                navigator: {
                    xAxis: {
                        dateTimeLabelFormats: {
                            day: "%Y-%m-%d",
                            week: "%Y",
                            month: "%Y-%m",
                            year: "%Y-%m"
                        }
                    }
                },
                noData: {
                    style: {
                        fontSize: "12px",
                        color: "#808080",
                        fontWeight: "100"
                    }
                },
                series: [{
                    type: "area",
                    data: b,
                    turboThreshold: Number.MAX_VALUE,
                    tooltip: {
                        valueDecimals: 2
                    }
                }]
            })
        }
    };
    var w = function () {};
    w.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#ACWorthTrend").highcharts("StockChart", {
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: "<p>累计净值：{point.y:.4f}</p>"
                },
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -118,
                        x: 162
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                noData: {
                    style: {
                        fontSize: "12px",
                        color: "#808080",
                        fontWeight: "100"
                    }
                },
                rangeSelector: {
                    inputEnabled: false,
                    buttonTheme: {
                        fill: "none",
                        stroke: "none",
                        "stroke-width": 0,
                        r: 0,
                        width: 33,
                        style: {
                            color: "#333",
                            fontWeight: "normal"
                        },
                        states: {
                            hover: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            },
                            select: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            }
                        }
                    },
                    labelStyle: {
                        color: "#333",
                        fontWeight: "bold"
                    },
                    buttons: [{
                        type: "month",
                        count: 1,
                        text: "1月"
                    }, {
                        type: "month",
                        count: 3,
                        text: "3月"
                    }, {
                        type: "month",
                        count: 6,
                        text: "6月"
                    }, {
                        type: "year",
                        count: 1,
                        text: "1年"
                    }, {
                        type: "year",
                        count: 3,
                        text: "3年"
                    }, {
                        type: "year",
                        count: 5,
                        text: "5年"
                    }, {
                        type: "ytd",
                        text: "今年来"
                    }, {
                        type: "all",
                        text: "最大"
                    }],
                    selected: 1
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value.toFixed(2)
                        }
                    },
                    tickPixelInterval: 50,
                    opposite: false,
                    reversed: false
                },
                title: {
                    text: ""
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null,
                        dataGrouping: {
                            enabled: false,
                            approximation: "open",
                            units: [
                                ["day", [1]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }
                },
                navigator: {
                    xAxis: {
                        dateTimeLabelFormats: {
                            day: "%Y-%m-%d",
                            week: "%Y",
                            month: "%Y-%m",
                            year: "%Y-%m"
                        }
                    }
                },
                series: [{
                    type: "area",
                    data: b,
                    tooltip: {
                        valueDecimals: 2
                    }
                }]
            })
        }
    };
    var C = function () {};
    C.prototype = {
        apiurl: "http://fund.eastmoney.com/api/PingZhongApi.ashx?m=0&fundcode=" + fS_code,
        init: function (c) {
            var b = this;
            b.grandWrap = a("#grandTotalCharsWrap");
            b.btnWrap = a(".grandTotalCharsControls .typeGrands ul");
            var d = c.dataList.concat();
            b.addGrandTotalMap(c.dataList);
            b.addMapBtn(c.dataList);
            b.nowDataList = d.concat();
            b.allDataList = b.nowDataList.concat();
            b.changeDataBind()
        }, addGrandTotalMap: function (c, d) {
            var e = this,
                b = "%Y-%m";
            if (d === "y") b = "%y-%m";
            a("#grandTotalCharsWrap").highcharts("StockChart", {
                noData: {
                    style: {
                        fontSize: "14px",
                        color: "#808080"
                    }
                },
                colors: ["#4c74b1", "#a44949", "#666"],
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -117,
                        x: 302
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: true,
                    useHTML: true,
                    labelFormatter: function () {
                        return this.name
                    }, margin: 30,
                    align: "left"
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: b,
                        year: "%Y"
                    }
                },
                yAxis: {
                    labels: {
                        formatter: function () {
                            return (this.value > 0 ? " + " : "") + this.value.toFixed(2) + "%"
                        }
                    },
                    plotLines: [{
                        value: 0,
                        width: 2,
                        color: "silver"
                    }]
                },
                plotOptions: {
                    line: {
                        dataGrouping: {
                            approximation: "open",
                            smoothed: true,
                            dateTimeLabelFormats: {
                                millisecond: [""],
                                second: [""],
                                minute: [""],
                                hour: [""],
                                day: ["%Y-%m-%d"],
                                month: ["%Y-%m-%d"],
                                year: ["%Y-%m-%d"],
                                all: ["%Y-%m-%d"]
                            }
                        }
                    }
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}%</b><br/>',
                    valueDecimals: 2
                },
                navigator: {
                    enabled: false
                },
                rangeSelector: {
                    enabled: false
                },
                series: c
            })
        }, addMapBtn: function (d) {
            var c = this,
                b = c.btnWrap.find("li");
            a.each(d, function (a, c) {
                b.eq(a).html(c.name).attr("data-findex", a)
            });
            b.on("click", function () {
                var e = a(this).index(),
                    d = a(this).attr("data-findex"),
                    b;
                if (a(this).hasClass("off")) {
                    a(this).removeClass("off");
                    b = "add"
                } else {
                    a(this).addClass("off");
                    b = "remove"
                }
                c.changeData(d, b)
            })
        }, changeDataBind: function () {
            var b = this;
            a("#grandTotalCharsWrap_selectRange").find("li").each(function (c, d) {
                if (c != 0) a(d).on("click", function () {
                    var d = a("#compareTargetSel option:selected").val(),
                        c = a(this).attr("data-type");
                    a("#grandTotalCharsWrap").html("");
                    a("#grandTotalCharsWrap").addClass("hasLoading");
                    a("#grandTotalCharsWrap_selectRange").find("li").removeClass("at");
                    a(this).addClass("at");
                    a.getJSON(b.apiurl + "&indexcode=" + d + "&type=" + c + "&callback=?", function (d) {
                        a("#grandTotalCharsWrap").removeClass("hasLoading");
                        b.addGrandTotalMap(d, c)
                    })
                })
            });
            a("#grandTotalCharsWrap_compare").on("click", function () {
                a("#grandTotalCharsWrap").html("");
                a("#grandTotalCharsWrap").addClass("hasLoading");
                var c = a("#compareTargetSel option:selected").val(),
                    d = a("#grandTotalCharsWrap_selectRange").find(".at").attr("data-type");
                a.getJSON(b.apiurl + "&indexcode=" + c + "&type=" + d + "&callback=?", function (c) {
                    a("#grandTotalCharsWrap").removeClass("hasLoading");
                    b.addGrandTotalMap(c)
                })
            })
        }
    };
    var m = function () {};
    m.prototype = {
        apiUrl: "http://fund.eastmoney.com/api/PingZhongApi.ashx?m=1",
        init: function (b) {
            this.initSelectChange();
            var a = b.dataList;
            this.initChart(a)
        }, initChart: function (c, b) {
            if (!b) b = "近3月排名";
            var d = a("#RateInSimilar_type");
            a("#RateInSimilar_type").highcharts("StockChart", {
                tooltip: {
                    useHTML: true,
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: "<p>每日" + b + "：{point.y}|{point.sc}</p>"
                },
                plotOptions: {
                    line: {
                        dataGrouping: {
                            enabled: false
                        }
                    }
                },
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -48,
                        x: 302
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                navigator: {
                    enabled: false
                },
                noData: {
                    style: {
                        fontSize: "14px",
                        color: "#808080"
                    }
                },
                rangeSelector: {
                    inputEnabled: false,
                    buttonTheme: {
                        fill: "none",
                        stroke: "none",
                        "stroke-width": 0,
                        r: 0,
                        width: 45,
                        style: {
                            color: "#333",
                            fontWeight: "normal"
                        },
                        states: {
                            hover: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            },
                            select: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            }
                        }
                    },
                    labelStyle: {
                        color: "#333",
                        fontWeight: "bold"
                    },
                    buttons: [{
                        type: "month",
                        count: 1,
                        text: "1月"
                    }, {
                        type: "month",
                        count: 3,
                        text: "3月"
                    }, {
                        type: "month",
                        count: 6,
                        text: "6月"
                    }, {
                        type: "year",
                        count: 1,
                        text: "1年"
                    }, {
                        type: "year",
                        count: 3,
                        text: "3年"
                    }, {
                        type: "year",
                        count: 5,
                        text: "5年"
                    }, {
                        type: "ytd",
                        text: "今年来"
                    }, {
                        type: "all",
                        text: "最大"
                    }],
                    selected: 2
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return parseFloat(this.value).toFixed(0)
                        }
                    },
                    tickPosition: "outside",
                    opposite: false,
                    reversed: true,
                    startOnTick: false,
                    minPadding: .5,
                    maxPadding: .5
                },
                title: {
                    text: ""
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                series: [{
                    data: c,
                    turboThreshold: Number.MAX_VALUE,
                    tooltip: {
                        valueDecimals: 0
                    }
                }]
            })
        }, initSelectChange: function () {
            var b = this;
            a("#RateInSimilar_type_select select").change(function () {
                a("#RateInSimilar_type").html("").addClass("hasLoading");
                var c = fS_code,
                    d = a(this).val(),
                    e = a(this).find("option:selected").text();
                a.getJSON(b.apiUrl + "&fundcode=" + c + "&range=" + d + "&callback=?", function (c) {
                    a("#RateInSimilar_type").removeClass("hasLoading");
                    b.initChart(c, e)
                })
            })
        }
    };
    var d = function () {};
    d.prototype = {
        apiUrl: "http://fund.eastmoney.com/api/PingZhongApi.ashx?m=2",
        init: function (a) {
            var c = a.dataList;
            seriesCounter = 0;
            var b = this;
            setTimeout(function () {
                b.createChart(a.dataList)
            }, 100);
            this.initSelectChange()
        }, createChart: function (c, b) {
            switch (b) {
            case "3y":
                b = "近3月收益排名百分比";
                break;
            case "6y":
                b = "近6月收益排名百分比";
                break;
            case "1n":
                b = "近1年收益排名百分比";
                break;
            default:
                b = "近3月收益排名百分比"
            }
            var d = a("#RateInSimilar_persent");
            a("#RateInSimilar_persent").highcharts("StockChart", {
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: "<p>每日" + b + "：{point.y}%</p>"
                },
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -48,
                        x: 302
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                navigator: {
                    enabled: false
                },
                noData: {
                    style: {
                        fontSize: "14px",
                        color: "#808080"
                    }
                },
                rangeSelector: {
                    inputEnabled: false,
                    buttonTheme: {
                        fill: "none",
                        stroke: "none",
                        "stroke-width": 0,
                        r: 0,
                        width: 45,
                        style: {
                            color: "#333",
                            fontWeight: "normal"
                        },
                        states: {
                            hover: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            },
                            select: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            }
                        }
                    },
                    labelStyle: {
                        color: "#333",
                        fontWeight: "bold"
                    },
                    buttons: [{
                        type: "month",
                        count: 1,
                        text: "1月"
                    }, {
                        type: "month",
                        count: 3,
                        text: "3月"
                    }, {
                        type: "month",
                        count: 6,
                        text: "6月"
                    }, {
                        type: "year",
                        count: 1,
                        text: "1年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [1]]
                            ]
                        }
                    }, {
                        type: "year",
                        count: 3,
                        text: "3年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [30]]
                            ]
                        }
                    }, {
                        type: "year",
                        count: 5,
                        text: "5年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [60]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "ytd",
                        text: "今年来"
                    }, {
                        type: "all",
                        text: "最大",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [60]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }],
                    selected: 2
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value.toFixed(0) + "%"
                        }
                    },
                    tickPixelInterval: 30,
                    opposite: false
                },
                title: {
                    text: ""
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                plotOptions: {
                    line: {
                        dataGrouping: {
                            approximation: "open",
                            smoothed: true,
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }
                },
                series: [{
                    data: c,
                    turboThreshold: Number.MAX_VALUE,
                    tooltip: {
                        valueDecimals: 2
                    }
                }]
            })
        }, initSelectChange: function () {
            _this = this;
            a("#RateInSimilar_persent_select select").change(function () {
                a("#RateInSimilar_persent").html("").addClass("hasLoading");
                var c = fS_code,
                    b = a(this).val();
                a.getJSON(_this.apiUrl + "&fundcode=" + c + "&range=" + b + "&callback=?", function (c) {
                    a("#RateInSimilar_persent").removeClass("hasLoading");
                    _this.createChart(c, b)
                })
            })
        }
    };
    var n = function () {};
    n.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#fluctuationScale").highcharts({
                colors: ["#4c74b1"],
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: ""
                },
                xAxis: {
                    categories: b.categories,
                    labels: {
                        formatter: function () {
                            return this.value.substr(5, 8)
                        }
                    }
                },
                noData: {
                    style: {
                        fontSize: "12px",
                        color: "#808080",
                        fontWeight: "100"
                    }
                },
                yAxis: {
                    title: {
                        text: "净资产 （亿元）"
                    },
                    tickPixelInterval: 40
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: false
                        }
                    }
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: '<span">净资产规模:</span> {point.y}亿元<br/><span>较上期环比:{point.mom}</span>'
                },
                series: [{
                    name: "Brands",
                    colorByPoint: false,
                    data: b.series
                }]
            })
        }
    };
    var s = function () {};
    s.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#HolderStructure").highcharts({
                colors: ["#7cb5ec", "#414c7b", "#69c8a8"],
                credits: {
                    enabled: false
                },
                noData: {
                    style: {
                        fontSize: "12px",
                        color: "#808080",
                        fontWeight: "100"
                    }
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: true
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: ""
                },
                subtitle: {
                    text: ""
                },
                xAxis: {
                    categories: b.categories,
                    labels: {
                        formatter: function () {
                            return this.value.substr(2, 8)
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    labels: {
                        formatter: function () {
                            return this.value + "%"
                        }
                    },
                    title: {
                        text: ""
                    },
                    max: 100
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table style="*width:150px">',
                    pointFormat: '<tr><td  style="color:{series.color};padding:0;*width:75px">{series.name}: </td><td style="padding:0;*width:75px"><b>{point.y:.2f} %</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: .2,
                        borderWidth: 0
                    }
                },
                series: b.series
            })
        }
    };
    var q = function () {};
    q.prototype = {
        init: function (c) {
            var b = c.dataList;
            b.series[0].tooltip = {
                valueDecimals: 2,
                valueSuffix: " %"
            };
            b.series[1].tooltip = {
                valueDecimals: 2,
                valueSuffix: " %"
            };
            b.series[2].tooltip = {
                valueDecimals: 2,
                valueSuffix: " %"
            };
            b.series[3].tooltip = {
                valueDecimals: 2,
                valueSuffix: " 亿元"
            };
            a("#assetAllocation").highcharts({
                colors: ["#7cb5ec", "#414c7b", "#69c8a8", "#7cb5ec"],
                chart: {},
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: true
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: ""
                },
                subtitle: {
                    text: ""
                },
                noData: {
                    style: {
                        fontSize: "12px",
                        color: "#808080",
                        fontWeight: "100"
                    }
                },
                xAxis: {
                    categories: b.categories,
                    labels: {
                        formatter: function () {
                            return this.value.substr(5, 8)
                        }
                    }
                },
                yAxis: [{
                    title: {
                        text: ""
                    },
                    min: 0,
                    labels: {
                        formatter: function () {
                            return this.value + "%"
                        }
                    }
                }, {
                    title: {
                        text: "资产规模(亿元)"
                    },
                    opposite: true
                }],
                tooltip: {
                    shared: true
                },
                plotOptions: {
                    column: {
                        pointPadding: .01,
                        borderWidth: 0
                    }
                },
                series: b.series
            })
        }
    };
    var k = function () {};
    k.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#assetAllocation").highcharts({
                colors: ["#7cb5ec", "#414c7b", "#69c8a8", "#7cb5ec"],
                chart: {},
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: true
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: ""
                },
                subtitle: {
                    text: ""
                },
                xAxis: {
                    categories: b.categories,
                    labels: {
                        formatter: function () {
                            return this.value.substr(0, 7)
                        }
                    }
                },
                yAxis: [{
                    title: {
                        text: ""
                    },
                    min: 0,
                    labels: {
                        formatter: function () {
                            return this.value.toFixed() + "亿份"
                        }
                    }
                }],
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table style="*width:130px">',
                    pointFormat: '<tr><td style="color:{series.color};padding:0;*width:130px">{series.name}: </td><td style="padding:0;*width:130px"><b>{point.y:.2f} 亿份</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: .01,
                        borderWidth: 0
                    }
                },
                series: b.series
            })
        }
    };
    var u = function () {};
    u.prototype = {
        init: function (c) {
            var b = c.dataList;
            a("#buySedemption").highcharts({
                colors: ["#7cb5ec", "#414c7b", "#69c8a8"],
                chart: {},
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: true
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: "",
                    align: "center"
                },
                subtitle: {
                    text: "份额(亿份)",
                    align: "left",
                    style: {
                        "font-family": "宋体",
                        "font-size": "11px"
                    }
                },
                xAxis: {
                    categories: b.categories,
                    labels: {
                        formatter: function () {
                            return this.value.replace("-", "").replace("-", "")
                        }, style: {
                            fontsize: "8px"
                        }
                    }
                },
                yAxis: [{
                    title: {
                        text: ""
                    },
                    min: 0,
                    labels: {
                        formatter: function () {
                            return parseInt(this.value)
                        }
                    }
                }, {
                    title: {
                        text: ""
                    },
                    opposite: true,
                    valueDecimals: 2
                }],
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table style="*width:130px;">',
                    pointFormat: '<tr><td style="color:{series.color};padding:0;*width:130px;">{series.name}: </td><td style="padding:0;*width:130px;"><b>{point.y:.2f} 亿份</b></td></tr>',
                    footerFormat: "</table>",
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: .01,
                        borderWidth: 0
                    }
                },
                series: b.series
            })
        }
    };
    var e = function () {};
    e.prototype = {
        init: function () {
            a("#fundInvestmentStyle").highcharts({
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    type: "column"
                },
                chart: {
                    type: "scatter",
                    zoomType: "xy"
                },
                title: {
                    text: "基金近一年投资风格"
                },
                subtitle: {
                    text: ""
                },
                xAxis: {
                    title: {
                        enabled: true,
                        text: ""
                    },
                    startOnTick: true,
                    endOnTick: true,
                    showLastLabel: true
                },
                yAxis: {
                    title: {
                        text: ""
                    }
                },
                legend: {},
                plotOptions: {
                    scatter: {
                        marker: {
                            radius: 5,
                            states: {
                                hover: {
                                    enabled: true,
                                    lineColor: "rgb(100,100,100)"
                                }
                            }
                        },
                        states: {
                            hover: {
                                marker: {
                                    enabled: false
                                }
                            }
                        },
                        tooltip: {
                            headerFormat: "<b>{series.name}</b><br>",
                            pointFormat: "{point.x} cm, {point.y} kg"
                        }
                    }
                },
                series: [{
                    name: "2015年1季度",
                    color: "rgba(223, 83, 83, .5)",
                    data: [
                        [161.2, 51.6],
                        [167.5, 59],
                        [159.5, 49.2],
                        [157, 63],
                        [155.8, 53.6]
                    ]
                }, {
                    name: "2016年1季度",
                    color: "rgba(119, 152, 191, .5)",
                    data: [
                        [174, 65.6],
                        [175.3, 71.8],
                        [193.5, 80.7],
                        [186.5, 72.6],
                        [187.2, 78.8]
                    ]
                }]
            })
        }
    };
    definePerformanceEvaluation.prototype = {
        init: function (g, c) {
            dataList = g;
            var f = a.cookie("pi") && a.cookie("pi") != "" || c && c.CustomerName && c.CustomerName != "";
            if (dataList.avr == null) dataList.avr = "暂无数据";
            if (!f) {
                dataList.data = [null, null, null, null, null];
                dataList.avr = '<a style="color:#4071b6;font-size:12px;font-family:宋体" href="https://trade.1234567.com.cn/login?direct_url=' + encodeURIComponent(location.href) + '">登录后可见</a>'
            }
            var b = a(".viewMoreFundAttr");
            if (b && b != null && b != "undefined") {
                var d = "基金特点：";
                a(b).on("mouseover", function () {
                    a(".performanceEvaluation .comments").html(d + a(".performanceEvaluation .comments").data("content"));
                    a(this).hide()
                });
                a(".performanceEvaluation .comments").on("mouseout", function () {
                    var c = a(".performanceEvaluation .comments").data("content");
                    a(".performanceEvaluation .comments").html(d + c.substr(0, 70) + (c.length > 70 ? "..." : ""));
                    a(b).show()
                })
            }
            var e = 0;
            a.each(dataList, function (b, a) {
                if (a) e += parseFloat(a)
            });
            a("#performanceEvaluation").highcharts({
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    polar: true,
                    type: "area",
                    marginLeft: 50,
                    marginRight: 50
                },
                title: {
                    text: dataList.avr == null || dataList.avr == "暂无数据" || dataList.avr.indexOf("登录") > -1 ? '<span style="color:gray;font-size:12px;font-family:宋体">' + dataList.avr + "</span>" : '<span style="color:#ff3300;font-size:24px;">' + dataList.avr + "</span>",
                    x: -6,
                    y: -3,
                    verticalAlign: "middle",
                    align: "center"
                },
                pane: {
                    size: "80%"
                },
                xAxis: {
                    categories: dataList.categories,
                    tickmarkPlacement: "on",
                    lineWidth: 0,
                    max: 5
                },
                yAxis: {
                    gridLineInterpolation: "polygon",
                    lineWidth: 0,
                    max: 100,
                    min: 0,
                    tickInterval: 50,
                    labels: {
                        enabled: false
                    }
                },
                tooltip: {
                    style: {
                        width: 50
                    },
                    shared: true,
                    formatter: function () {
                        var b = "<b>" + this.x + "</b>：" + this.y.toFixed(2);
                        a.each(this.points, function () {
                            var a;
                            switch (this.x) {
                            case dataList.categories[0]:
                                a = dataList.dsc[0];
                                break;
                            case dataList.categories[1]:
                                a = dataList.dsc[1];
                                break;
                            case dataList.categories[2]:
                                a = dataList.dsc[2];
                                break;
                            case dataList.categories[3]:
                                a = dataList.dsc[3];
                                break;
                            case dataList.categories[4]:
                                a = dataList.dsc[4]
                            }
                            b += "<br/>" + a
                        });
                        return b
                    }
                },
                series: [{
                    data: dataList.data,
                    pointPlacement: "on"
                }],
                lang: {
                    noData: ""
                }
            })
        }
    };
    var o = function () {};
    o.prototype = {
        init: function () {
            a(".fundManagerPower").highcharts({
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    polar: true,
                    type: "area",
                    marginLeft: 50,
                    marginRight: 50
                },
                title: {
                    text: '<span style="color:#ff3300;font-size:24px;">4.5</span>',
                    x: -6,
                    y: -3,
                    verticalAlign: "middle",
                    align: "center"
                },
                pane: {
                    size: "80%"
                },
                xAxis: {
                    categories: ["选股能力", "收益率", "抗风险", "稳定性", "择时能力"],
                    tickmarkPlacement: "on",
                    lineWidth: 0,
                    max: 5
                },
                yAxis: {
                    gridLineInterpolation: "polygon",
                    categories: ["", "", "", "", ""],
                    lineWidth: 0,
                    max: 5,
                    min: 0
                },
                tooltip: {
                    shared: true,
                    formatter: function () {
                        var b = "<b>" + this.x + "</b>：" + this.y;
                        a.each(this.points, function () {
                            var a;
                            switch (this.x) {
                            case "选股能力":
                                a = "反映基金挑选股票而实现风险调整后获得<br/>超额收益的<br/>能力。";
                                break;
                            case "收益率":
                                a = "根据基金的阶段收益评分，反映基金的<br/>盈利能力。";
                                break;
                            case "抗风险":
                                a = "反映基金投资收益的回撤情况。";
                                break;
                            case "稳定性":
                                a = "反映基金投资收益的波动性。";
                                break;
                            case "择时能力":
                                a = "反映基金根据对市场走势的判断，通过<br/>调整仓位及配置而跑赢基金业绩基准的<br/>能力。"
                            }
                            b += "<br/>" + a
                        });
                        return b
                    }
                },
                series: [{
                    data: [5, 4, 3, 2, 2],
                    pointPlacement: "on"
                }]
            })
        }
    };
    var B = function () {};
    B.prototype = {
        init: function () {
            a(".fundProfit").highcharts({
                colors: ["#4c74b1"],
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: ""
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                yAxis: {
                    title: {
                        text: "净资产 （亿元）"
                    },
                    tickPixelInterval: 30
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: '<span">任职收益:</span>: {point.y}%'
                },
                series: [{
                    name: "Brands",
                    colorByPoint: false,
                    data: [
                        [1.1476512e12, 23.15],
                        [1.1600064e12, 27.92],
                        [1.1800064e12, 47.92],
                        [1.1975904e12, 90.39],
                        [1.2102912e12, 29.39]
                    ]
                }]
            })
        }
    };
    var p = function () {};
    p.prototype = {
        init: function () {
            this.millionCopiesIncome();
            this.sevenDaysYearIncome()
        }, millionCopiesIncome: function () {}, sevenDaysYearIncome: function () {
            a.getJSON("http://www.hcharts.cn/datas/jsonp.php?filename=usdeur.json&callback=?", function (b) {
                a("#quotationItem02").highcharts("StockChart", {
                    credits: {
                        enabled: false
                    },
                    tooltip: {
                        xDateFormat: "%Y-%m-%d",
                        pointFormat: '<span style="color:#4c74b1;">每万份收益</span>: {point.y}元'
                    },
                    data: {
                        dateFormat: "YYYY-mm-dd"
                    },
                    title: {
                        text: "<b>7日年化收益率</b>",
                        style: {
                            color: "#333",
                            fontSize: "12px"
                        }
                    },
                    xAxis: {
                        type: "datetime",
                        dateTimeLabelFormats: {
                            day: "%m-%d",
                            week: "%m-%d",
                            month: "%Y-%m",
                            year: "%Y"
                        }
                    },
                    yAxis: {
                        title: {
                            text: ""
                        },
                        labels: {
                            formatter: function () {
                                return this.value + "元"
                            }
                        },
                        tickPixelInterval: 30
                    },
                    rangeSelector: {
                        inputEnabled: false,
                        buttonTheme: {
                            fill: "none",
                            stroke: "none",
                            "stroke-width": 0,
                            r: 0,
                            width: 45,
                            style: {
                                color: "#333",
                                fontWeight: "normal"
                            },
                            states: {
                                hover: {
                                    fill: "#4c74b1",
                                    style: {
                                        color: "#fff",
                                        fontWeight: "bold"
                                    }
                                },
                                select: {
                                    fill: "#4c74b1",
                                    style: {
                                        color: "#fff",
                                        fontWeight: "bold"
                                    }
                                }
                            }
                        },
                        labelStyle: {
                            color: "#333",
                            fontWeight: "bold"
                        },
                        buttons: [{
                            type: "month",
                            count: 1,
                            text: "1月"
                        }, {
                            type: "month",
                            count: 3,
                            text: "3月"
                        }, {
                            type: "month",
                            count: 6,
                            text: "6月"
                        }, {
                            type: "year",
                            count: 1,
                            text: "1年"
                        }, {
                            type: "year",
                            count: 3,
                            text: "3年"
                        }, {
                            type: "year",
                            count: 5,
                            text: "5年"
                        }, {
                            type: "ytd",
                            text: "今年来"
                        }, {
                            type: "all",
                            text: "最大"
                        }],
                        selected: 1
                    },
                    exporting: {
                        enabled: false
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        area: {
                            fillColor: {
                                linearGradient: {
                                    x1: 0,
                                    y1: 0,
                                    x2: 0,
                                    y2: 1
                                },
                                stops: [
                                    [0, Highcharts.getOptions().colors[0]],
                                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")]
                                ]
                            },
                            marker: {
                                radius: 2
                            },
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 1
                                }
                            },
                            threshold: null
                        }
                    },
                    plotOptions: {
                        line: {
                            dataGrouping: {
                                approximation: "open",
                                smoothed: true,
                                dateTimeLabelFormats: {
                                    millisecond: [""],
                                    second: [""],
                                    minute: [""],
                                    hour: [""],
                                    day: ["%Y-%m-%d"],
                                    month: ["%Y-%m-%d"],
                                    year: ["%Y-%m-%d"],
                                    all: ["%Y-%m-%d"]
                                }
                            }
                        }
                    },
                    series: [{
                        name: "股票仓位百分比",
                        data: b
                    }]
                })
            })
        }
    };
    var g = function () {};
    g.prototype = {
        init: function (b) {
            a("#quotationItem01").highcharts("StockChart", {
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -124,
                        x: 150
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: '<span style="color:#4c74b1;">每万元收益</span>: {point.y:.4f}元'
                },
                data: {
                    dateFormat: "YYYY-mm-dd"
                },
                title: {
                    text: "<b>每万元收益</b>",
                    style: {
                        color: "#333",
                        fontSize: "12px"
                    }
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value.toFixed(2) + "元"
                        }
                    },
                    tickPixelInterval: 30
                },
                rangeSelector: {
                    inputEnabled: false,
                    buttonTheme: {
                        fill: "none",
                        stroke: "none",
                        "stroke-width": 0,
                        r: 0,
                        width: 43,
                        style: {
                            color: "#333",
                            fontWeight: "normal"
                        },
                        states: {
                            hover: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            },
                            select: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            }
                        }
                    },
                    labelStyle: {
                        color: "#333",
                        fontWeight: "bold"
                    },
                    buttons: [{
                        type: "month",
                        count: 1,
                        text: "1月"
                    }, {
                        type: "month",
                        count: 3,
                        text: "3月"
                    }, {
                        type: "month",
                        count: 6,
                        text: "6月"
                    }, {
                        type: "year",
                        count: 1,
                        text: "1年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [5]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "year",
                        count: 3,
                        text: "3年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [10]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "year",
                        count: 5,
                        text: "5年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [30]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "ytd",
                        text: "今年来"
                    }, {
                        type: "all",
                        text: "最大",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [60]]
                            ],
                            dateTimeLabelFormats: {
                                millisecond: [""],
                                second: [""],
                                minute: [""],
                                hour: [""],
                                day: ["%Y-%m-%d", "%Y-%m-%d"],
                                month: ["%Y-%m-%d"],
                                year: ["%Y-%m-%d"],
                                all: ["%Y-%m-%d"]
                            }
                        }
                    }],
                    selected: 1
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null
                    }
                },
                navigator: {
                    xAxis: {
                        dateTimeLabelFormats: {
                            day: "%Y-%m-%d",
                            week: "%Y",
                            month: "%Y-%m",
                            year: "%Y-%m"
                        }
                    }
                },
                series: [{
                    name: "",
                    data: b.dataList
                }]
            })
        }
    };
    var h = function () {};
    h.prototype = {
        init: function (b) {
            a("#quotationItem02").highcharts("StockChart", {
                credits: {
                    text: '<span style="font-size:16px;color:#999999;font-family: Microsoft YaHei;">天天基金网</span>',
                    href: "javascript:;",
                    position: {
                        align: "center",
                        y: -124,
                        x: 150
                    },
                    style: {
                        cursor: "default",
                        color: "#999999",
                        fontSize: "10px",
                        "font-family": "Microsoft YaHei"
                    }
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    pointFormat: '<span style="color:#4c74b1;">7日年化</span>: {point.y:.4f}%'
                },
                data: {
                    dateFormat: "YYYY-mm-dd"
                },
                title: {
                    text: "<b>7日年化收益率</b>",
                    style: {
                        color: "#333",
                        fontSize: "12px"
                    }
                },
                xAxis: {
                    type: "datetime",
                    dateTimeLabelFormats: {
                        day: "%m-%d",
                        week: "%m-%d",
                        month: "%Y-%m",
                        year: "%Y"
                    }
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value.toFixed(2) + "%"
                        }
                    },
                    tickPixelInterval: 30
                },
                rangeSelector: {
                    inputEnabled: false,
                    buttonTheme: {
                        fill: "none",
                        stroke: "none",
                        "stroke-width": 0,
                        r: 0,
                        width: 43,
                        style: {
                            color: "#333",
                            fontWeight: "normal"
                        },
                        states: {
                            hover: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            },
                            select: {
                                fill: "#4c74b1",
                                style: {
                                    color: "#fff",
                                    fontWeight: "bold"
                                }
                            }
                        }
                    },
                    labelStyle: {
                        color: "#333",
                        fontWeight: "bold"
                    },
                    buttons: [{
                        type: "month",
                        count: 1,
                        text: "1月"
                    }, {
                        type: "month",
                        count: 3,
                        text: "3月"
                    }, {
                        type: "month",
                        count: 6,
                        text: "6月"
                    }, {
                        type: "year",
                        count: 1,
                        text: "1年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [5]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "year",
                        count: 3,
                        text: "3年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [10]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "year",
                        count: 5,
                        text: "5年",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [30]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "ytd",
                        text: "今年来",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [5]]
                            ],
                            dateTimeLabelFormats: {
                                day: ["%Y-%m-%d", "%Y-%m-%d"]
                            }
                        }
                    }, {
                        type: "all",
                        text: "最大",
                        dataGrouping: {
                            approximation: "open",
                            units: [
                                ["day", [60]]
                            ],
                            dateTimeLabelFormats: {
                                millisecond: [""],
                                second: [""],
                                minute: [""],
                                hour: [""],
                                day: ["%Y-%m-%d", "%Y-%m-%d"],
                                month: ["%Y-%m-%d"],
                                year: ["%Y-%m-%d"],
                                all: ["%Y-%m-%d"]
                            }
                        }
                    }],
                    selected: 1
                },
                exporting: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    area: {
                        fillColor: {
                            linearGradient: {
                                x1: 0,
                                y1: 0,
                                x2: 0,
                                y2: 1
                            },
                            stops: [
                                [0, Highcharts.getOptions().colors[0]],
                                [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get("rgba")]
                            ]
                        },
                        marker: {
                            radius: 2
                        },
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 1
                            }
                        },
                        threshold: null,
                        dataGrouping: {
                            enabled: false
                        }
                    }
                },
                navigator: {
                    xAxis: {
                        dateTimeLabelFormats: {
                            day: "%Y-%m-%d",
                            week: "%Y",
                            month: "%Y-%m",
                            year: "%Y-%m"
                        }
                    }
                },
                series: [{
                    name: "股票仓位百分比",
                    data: b.dataList
                }]
            })
        }
    };
    var c = function () {};
    c.prototype = {
        init: function (b) {
            b.dataList.series[0].color = "#F7A35C";
            b.dataList.series[1].color = "#90ED7D";
            b.dataList.series[2].color = "#7CB5EC";
            a("#assetAllocationMain").highcharts({
                color: ["#F7A35C", "#90ED7D", "#7CB5EC"],
                chart: {
                    type: "bar"
                },
                title: {
                    text: ""
                },
                subtitle: {
                    text: ""
                },
                xAxis: {
                    categories: b.dataList.categories,
                    title: {
                        text: null
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: "占净值比（%）",
                        align: "high"
                    },
                    labels: {
                        overflow: "justify"
                    },
                    tickInterval: 50
                },
                tooltip: {
                    shared: true,
                    valueDecimals: 2,
                    valueSuffix: " %"
                },
                plotOptions: {
                    bar: {
                        dataLabels: {
                            enabled: true
                        }
                    }
                },
                legend: {
                    align: "right",
                    verticalAlign: "top",
                    x: 0,
                    y: 0,
                    floating: false,
                    borderWidth: 0,
                    backgroundColor: Highcharts.theme && Highcharts.theme.legendBackgroundColor || "#FFFFFF",
                    shadow: false,
                    layout: "horizontal",
                    width: 220,
                    padding: 5,
                    symbolWidth: 12,
                    align: "left"
                },
                credits: {
                    enabled: false
                },
                navigation: {
                    buttonOptions: {
                        enabled: false
                    }
                },
                series: b.dataList.series
            })
        }
    };
    var j = function () {};
    j.prototype = {
        init: function (c) {
            var b = this;
            b.fundManagerWrap = a(".fundManagerWrap");
            b.btnWrap = a(".fundManagerList");
            b.infoWrap = a(".fundManagerInfo");
            b.dataList = c.dataList;
            b.defaultIndex = 0;
            b.initBtn();
            b.initWrap(b.defaultIndex)
        }, initBtn: function () {
            var b = this;
            b.btnWrap.find("dd").remove();
            a.each(b.dataList, function (e, d) {
                var c = d.name,
                    a = e == b.defaultIndex ? "FMlist_Btn fmActive" : "FMlist_Btn";
                b.btnWrap.append("<dd class='" + a + "''>" + c + "</dd>")
            });
            b.btnWrap.find("dd").on("click", function () {
                b.btnWrap.find("dd").removeClass("fmActive");
                a(this).addClass("fmActive");
                b.initWrap(a(this).index() - 1)
            });
            b.btnWrap.show()
        }, initWrap: function (e) {
            var c = this,
                b = c.dataList[e];
            if (b && b != null && typeof b != "undefined") {
                var d = c.infoWrap.find(".ManagerPic img");
                d && typeof d != "undefined" && c.infoWrap.find(".ManagerPic img").attr("src", b.pic);
                c.infoWrap.find(".ManagerInfo .M_name").html('<a href="http://fund.eastmoney.com/manager/' + b.id + '.html">' + b.name + "</a>");
                c.infoWrap.find(".ManagerInfo .M_levels").html(c.star(b.star) + "<div class='tipsBubble'>点评内容为针对基金经理过往情况的评价，不代表其未来表现，仅供参考。</div>");
                c.infoWrap.find(".ManagerInfo .M_date").html(b.workTime);
                c.infoWrap.find(".ManagerInfo .fundScale").html(b.fundSize);
                c.addPowerMap(b.power);
                c.infoWrap.find(".fundManagerPower_jzrq").html("截止至：" + (b.power.jzrq ? b.power.jzrq : "--"));
                c.addProfitMap(b.profit);
                c.infoWrap.find(".fundProfit_jzrq").html("截止至：" + (b.profit.jzrq ? b.profit.jzrq : "--"));
                c.infoWrap.show();
                c.fundManagerWrap.show()
            }
            a(c.fundManagerWrap).parent().removeClass("hasLoading")
        }, star: function (a) {
            var b = "";
            if (a == 0) return "<span style='color:#333'>--</span>";
            while (a > 0) {
                b += "★";
                a--
            }
            return b
        }, addPowerMap: function (b) {
            var c = 0;
            a.each(b, function (b, a) {
                c += parseFloat(a)
            });
            a(".fundManagerPower").highcharts({
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    polar: true,
                    type: "area",
                    marginLeft: 50,
                    marginRight: 50
                },
                title: {
                    text: b.avr == "暂无数据" ? '<span style="color:#808080;font-size:12px;">' + b.avr + "</span>" : '<span style="color:#ff3300;font-size:24px;">' + b.avr + "</span>",
                    x: -6,
                    y: -3,
                    verticalAlign: "middle",
                    align: "center"
                },
                pane: {
                    size: "80%"
                },
                xAxis: {
                    categories: b.categories,
                    tickmarkPlacement: "on",
                    lineWidth: 0,
                    max: 5
                },
                yAxis: {
                    gridLineInterpolation: "polygon",
                    categories: ["", "", "", "", ""],
                    lineWidth: 0,
                    max: 100,
                    min: 0,
                    tickInterval: 50,
                    labels: {
                        enabled: false
                    }
                },
                tooltip: {
                    shared: true,
                    formatter: function () {
                        var c = "<b>" + this.x + "</b>：" + this.y.toFixed(2);
                        a.each(this.points, function () {
                            var a;
                            switch (this.x) {
                            case b.categories[0]:
                                a = b.dsc[0];
                                break;
                            case b.categories[1]:
                                a = b.dsc[1];
                                break;
                            case b.categories[2]:
                                a = b.dsc[2];
                                break;
                            case b.categories[3]:
                                a = b.dsc[3];
                                break;
                            case b.categories[4]:
                                a = b.dsc[4]
                            }
                            c += "<br/>" + a
                        });
                        return c
                    }
                },
                series: [{
                    data: b.data,
                    pointPlacement: "on"
                }],
                lang: {
                    noData: ""
                }
            })
        }, addProfitMap: function (b) {
            a(".fundProfit").highcharts({
                credits: {
                    enabled: false
                },
                exporting: {
                    enabled: false
                },
                scrollbar: {
                    enabled: false
                },
                legend: {
                    enabled: false
                },
                chart: {
                    type: "column"
                },
                title: {
                    text: ""
                },
                xAxis: {
                    categories: b.categories
                },
                yAxis: {
                    title: {
                        text: ""
                    },
                    labels: {
                        formatter: function () {
                            return this.value >= 0 ? '<b style="color:red">' + this.value + "%</b>" : '<b style="color:green">' + this.value + "%</b>"
                        }
                    },
                    tickPixelInterval: 80
                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: false
                        }
                    }
                },
                tooltip: {
                    xDateFormat: "%Y-%m-%d",
                    formatter: function () {
                        return "<b>" + this.x + ":</b><b>" + this.y.toFixed(2) + "%</b>"
                    }
                },
                series: b.series
            })
        }
    };
    window._FUNDTYPE_ = {
        component: {
            bottomSwith: x,
            stockWindow: z,
            ie678Hack: E,
            calculator: A,
            tipsBubble: D,
            popTab: H,
            highcharsConfig: r,
            fundSharesPositions: f,
            netWorthTrend: v,
            ACWorthTrend: w,
            grandTotal: C,
            rateInSimilarType: m,
            rateInSimilarPersent: d,
            fluctuationScale: n,
            holderStructure: s,
            assetAllocation: q,
            fundInvestmentStyle: e,
            performanceEvaluation: definePerformanceEvaluation,
            fundManagerPower: o,
            fundProfit: B,
            topSearch: G,
            fundRevenueTrend: p,
            assetAllocationCurrency: c,
            currentFundManager: j,
            sevenDaysYearIncome: h,
            millionCopiesIncome: g,
            popTab_TLZFBMore: y,
            buySedemption: u,
            assetAllocation_hb: k,
            jjyw_More: F,
            reloadestimatedMap: l
        },
        installComponent: function (b) {
            var d = this,
                a;
            for (a in b) {
                var c = new d.component[a];
                c.init(b[a])
            }
        }
    }
})(window.jQuery);