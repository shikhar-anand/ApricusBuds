/*
 * HC Off-canvas Nav
 * ===================
 * Version: 5.0.10
 * Author: Some Web Media
 * Author URL: https://github.com/somewebmedia/
 * Plugin URL: https://github.com/somewebmedia/hc-offcanvas-nav
 * Description: JavaScript library for creating off-canvas multi-level navigations
 * License: MIT
 */
"use strict";
!function (e, t) {
    if ("object" == typeof module && "object" == typeof module.exports) {
        if (!e.document)
            throw new Error("HC Off-canvas Nav requires a browser to run.");
        module.exports = t(e)
    } else
        "function" == typeof define && define.amd ? define("hcOffcanvasNav", [], t(e)) : t(e)
}("undefined" != typeof window ? window : this, function (ne) {
    var ae = ne.document,
            re = ae.getElementsByTagName("html")[0],
            ie = 0,
            i = function (e, t) {
                if (t = t || {}, "string" == typeof e && (e = "#" === e.charAt(0) && -1 === e.indexOf(" ") ? ae.querySelector(e) : ae.querySelectorAll(e)), !e)
                    return !1;
                var J = i.Helpers;
                void 0 !== t.maxWidth && (J.deprecated("maxWidth", "disableAt", "option"), t.disableAt = t.maxWidth);
                var R = Object.assign({}, {
                    width: 280,
                    height: "auto",
                    disableAt: !1,
                    pushContent: null,
                    swipeGestures: !0,
                    expanded: !1,
                    position: "left",
                    levelOpen: "overlap",
                    levelSpacing: 40,
                    levelTitles: !0,
                    closeOpenLevels: !0,
                    closeActiveLevel: !1,
                    navTitle: null,
                    navClass: "",
                    disableBody: !0,
                    closeOnClick: !0,
                    customToggle: null,
                    bodyInsert: "prepend",
                    keepClasses: !0,
                    removeOriginalNav: !1,
                    rtl: !1,
                    insertClose: !0,
                    insertBack: !0,
                    levelTitleAsBack: !0,
                    labelClose: "Close",
                    labelBack: "Back",
                    ariaLabels: {
                        open: "Open Menu",
                        close: "Close Menu",
                        submenu: "Submenu"
                    }
                }, t),
                        Z = [],
                        ee = "nav-open",
                        te = function (e) {
                            if (!Z.length)
                                return !1;
                            var t = !1;
                            "string" == typeof e && (e = [e]);
                            for (var n = e.length, a = 0; a < n; a++)
                                -1 !== Z.indexOf(e[a]) && (t = !0);
                            return t
                        },
                        n = function (e) {
                            if (e.querySelector("ul") || "UL" === e.tagName) {
                                var E = "hc-nav-" + ++ie,
                                        o = J.printStyle("hc-offcanvas-" + ie + "-style"),
                                        s = "keydown.hcOffcanvasNav",
                                        c = J.createElement("nav", {
                                            role: "navigation"
                                        }),
                                        v = J.createElement("div", {
                                            class: "nav-container"
                                        });
                                c.addEventListener("click", J.stopPropagation), c.appendChild(v);
                                var t, u, n, d = null,
                                        p = null,
                                        a = {},
                                        f = !1,
                                        h = !1,
                                        m = null,
                                        y = 0,
                                        b = 0,
                                        g = 0,
                                        L = null,
                                        A = {},
                                        x = [],
                                        C = !1,
                                        k = [],
                                        l = null,
                                        O = null,
                                        N = !1,
                                        T = !1;
                                R.customToggle ? (d = J.getElement(R.customToggle)) && (d.classList.add("hc-nav-trigger", E), d.addEventListener("click", G)) : ((d = J.createElement("a", {
                                    href: "#",
                                    class: "hc-nav-trigger " + E,
                                    "aria-label": (R.ariaLabels || {}).open
                                }, J.createElement("span"))).addEventListener("click", G), e.insertAdjacentElement("afterend", d)), d.setAttribute("role", "button"), d.setAttribute("aria-controls", E), d.addEventListener("keydown", function (e) {
                                    "Enter" !== e.key && 13 !== e.keyCode || setTimeout(function () {
                                        w(0, 0)
                                    }, 0)
                                });
                                var w = function (e, t, n) {
                                    if ("number" == typeof t && ("number" == typeof e || k.length)) {
                                        var a = Array.prototype.filter.call(v.querySelectorAll(".nav-wrapper"), function (e) {
                                            return e.getAttribute("data-level") == t && ("number" != typeof n || "number" == typeof n && e.getAttribute("data-index") == n)
                                        })[0];
                                        if (a = J.children(a, ".nav-content")[0], a = J.children(a, "ul"), a = J.children(a, "li"), a = J.children(a, ":not(.nav-wrapper)"), a = Array.prototype.map.call(a, function (e) {
                                            return Array.prototype.slice.call(e.querySelectorAll('[tabindex="0"], a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'))
                                        }).flat(), a = Array.prototype.filter.call(a, function (e) {
                                            return "-1" !== e.getAttribute("tabindex")
                                        })) {
                                            var r = a[0],
                                                    i = a[a.length - 1];
                                            "number" == typeof e ? a[e].focus() : (k[k.length - 1].focus(), k.pop()), ae.removeEventListener(s), ae.addEventListener(s, function (e) {
                                                "Tab" !== e.key && 9 !== e.keyCode || (e.shiftKey ? ae.activeElement === r && (e.preventDefault(), i.focus()) : ae.activeElement === i && (e.preventDefault(), r.focus()))
                                            })
                                        }
                                    }
                                },
                                        S = function () {
                                            ae.removeEventListener(s), setTimeout(function () {
                                                d.focus()
                                            }, u)
                                        },
                                        M = function () {
                                            v.style.transition = "none", b = v.offsetWidth, g = v.offsetHeight, o.add(".hc-offcanvas-nav." + E + ".nav-position-left .nav-container", "transform: translate3d(-" + b + "px, 0, 0)"), o.add(".hc-offcanvas-nav." + E + ".nav-position-right .nav-container", "transform: translate3d(" + b + "px, 0, 0)"), o.add(".hc-offcanvas-nav." + E + ".nav-position-top .nav-container", "transform: translate3d(0, -" + g + "px, 0)"), o.add(".hc-offcanvas-nav." + E + ".nav-position-bottom .nav-container", "transform: translate3d(0, " + g + "px, 0)"), o.insert(), v.style.transition = "", t = ne.getComputedStyle(v).transitionProperty, u = J.toMs(ne.getComputedStyle(v).transitionDuration), n = ne.getComputedStyle(v).transitionTimingFunction, R.pushContent && p && t && o.add(J.getElementCssTag(p), "transition: " + t + " " + u + "ms " + n), o.insert()
                                        },
                                        r = function (e) {
                                            var t = ne.getComputedStyle(d).display,
                                                    n = !!R.disableAt && "max-width: " + (R.disableAt - 1) + "px",
                                                    a = J.formatSizeVal(R.width),
                                                    r = J.formatSizeVal(R.height);
                                            -1 !== a.indexOf("px") && (b = parseInt(a)), -1 !== r.indexOf("px") && (g = parseInt(r)), te(["disableAt", "position"]) && o.reset(), o.add(".hc-offcanvas-nav." + E, "display: block", n), o.add(".hc-nav-original." + E, "display: none", n), o.add(".hc-nav-trigger." + E, "display: " + (t && "none" !== t ? t : "block"), n), -1 !== ["left", "right"].indexOf(R.position) ? o.add(".hc-offcanvas-nav." + E + " .nav-container", "width: " + a) : o.add(".hc-offcanvas-nav." + E + " .nav-container", "height: " + r), o.add(".hc-offcanvas-nav." + E + ".nav-position-left .nav-container", "transform: translate3d(-" + ("auto" === a ? "100%" : a) + ", 0, 0);"), o.add(".hc-offcanvas-nav." + E + ".nav-position-right .nav-container", "transform: translate3d(" + ("auto" === a ? "100%" : a) + ", 0, 0);"), o.add(".hc-offcanvas-nav." + E + ".nav-position-top .nav-container", "transform: translate3d(0, -" + ("auto" === r ? "100%" : r) + ", 0);"), o.add(".hc-offcanvas-nav." + E + ".nav-position-bottom .nav-container", "transform: translate3d(0, " + ("auto" === r ? "100%" : r) + ", 0);"), o.add(".hc-offcanvas-nav." + E + ".nav-levels-overlap.nav-position-left li.level-open > .nav-wrapper", "transform: translate3d(-" + R.levelSpacing + "px,0,0)", n), o.add(".hc-offcanvas-nav." + E + ".nav-levels-overlap.nav-position-right li.level-open > .nav-wrapper", "transform: translate3d(" + R.levelSpacing + "px,0,0)", n), o.add(".hc-offcanvas-nav." + E + ".nav-levels-overlap.nav-position-top li.level-open > .nav-wrapper", "transform: translate3d(0,-" + R.levelSpacing + "px,0)", n), o.add(".hc-offcanvas-nav." + E + ".nav-levels-overlap.nav-position-bottom li.level-open > .nav-wrapper", "transform: translate3d(0," + R.levelSpacing + "px,0)", n), o.insert(), (!e || e && te("pushContent")) && (p = J.getElement(R.pushContent)), v.style.transition = "none";
                                            var i = c.classList.contains(ee),
                                                    s = ["hc-offcanvas-nav", R.navClass || "", E, R.navClass || "", "nav-levels-" + R.levelOpen || "none", "nav-position-" + R.position, R.disableBody ? "disable-body" : "", J.isIos ? "is-ios" : "", J.isTouchDevice ? "touch-device" : "", i ? ee : "", R.rtl ? "rtl" : "", !R.labelClose || "" === R.labelClose && R.insertClose ? "close-no-label" : ""].join(" ").trim().replace(/  +/g, " ");
                                            c.removeEventListener("click"), c.className = s, c.setAttribute("aria-hidden", !0), c.setAttribute("aria-labelledby", E), R.disableBody && c.addEventListener("click", Y), e ? M() : setTimeout(M, 0)
                                        },
                                        i = function () {
                                            var t;
                                            a = function o(e, t) {
                                                var n = [];
                                                Array.prototype.forEach.call(e, function (e) {
                                                    var s = {
                                                        id: t,
                                                        classes: e.getAttribute("class") || null,
                                                        items: []
                                                    };
                                                    null !== e.getAttribute("data-nav-active") && (m = t, e.removeAttribute("data-nav-active")), Array.prototype.forEach.call(e.children, function (e) {
                                                        var t = null !== e.getAttribute("data-nav-custom-content"),
                                                                n = t ? e.children : Array.prototype.filter.call(e.children, function (e) {
                                                                    return "UL" !== e.tagName && !e.querySelector("ul")
                                                                }).concat(e.children.length ? [] : [e.firstChild]),
                                                                a = t ? [] : Array.prototype.slice.call(e.querySelectorAll("ul")),
                                                                r = a.length ? [a[0]].concat(Array.prototype.filter.call(a[0].parentNode.children, function (e) {
                                                            return "UL" === e.tagName && e !== a[0]
                                                        })) : [],
                                                                i = null;
                                                        r.length && (J.data(e, "hc-uniqid") ? i = J.data(e, "hc-uniqid") : (i = Math.random().toString(36).substr(2), J.data(e, "hc-uniqid", i))), null !== e.getAttribute("data-nav-active") && (m = i, e.removeAttribute("data-nav-active")), s.items.push({
                                                            id: i,
                                                            classes: e.getAttribute("class") || "",
                                                            content: n,
                                                            custom: t,
                                                            subnav: r.length ? o(r, i) : [],
                                                            highlight: null !== e.getAttribute("data-nav-highlight")
                                                        })
                                                    }), n.push(s)
                                                });
                                                return n
                                            }((t = Array.prototype.slice.call(e.querySelectorAll("ul")), "UL" === e.tagName && t.unshift(e), [t[0]].concat(Array.prototype.filter.call(t[0].parentNode.children, function (e) {
                                                return e !== t[0]
                                            }))), null)
                                        },
                                        P = function (e) {
                                            if (e) {
                                                for (; v.firstChild; )
                                                    v.removeChild(v.firstChild);
                                                A = {}
                                            }
                                            !function m(e, t, y, b, n, a) {
                                                var g = J.createElement("div", {
                                                    class: "nav-wrapper nav-wrapper-" + y,
                                                    "data-level": y,
                                                    "data-index": n || 0
                                                });
                                                var r = J.createElement("div", {
                                                    class: "nav-content"
                                                });
                                                g.addEventListener("click", J.stopPropagation);
                                                g.appendChild(r);
                                                t.appendChild(g);
                                                b && r.insertBefore(J.createElement("h2", {
                                                    class: 0 === y ? "nav-title" : "level-title"
                                                }, b), r.firstChild);
                                                e.forEach(function (e, t) {
                                                    var h = J.createElement("ul", {
                                                        role: "menu",
                                                        "aria-level": y + 1
                                                    });
                                                    r.appendChild(h), R.keepClasses && e.classes && h.classList.add.apply(h.classList, e.classes.split(" ")), 0 === t && b && h.setAttribute("aria-label", b), e.id && h.setAttribute("aria-labelledby", "menu-" + e.id), e.items.forEach(function (e, t) {
                                                        var n = e.content;
                                                        if (e.custom) {
                                                            var a = J.createElement("li", {
                                                                class: "custom-content"
                                                            }, J.createElement("div", {
                                                                class: "nav-item nav-item-custom"
                                                            }, Array.prototype.map.call(n, function (e) {
                                                                return J.clone(e, !0, !0)
                                                            })));
                                                            return R.keepClasses && e.classes && a.classList.add.apply(a.classList, e.classes.split(" ")), void h.appendChild(a)
                                                        }
                                                        var r, i = Array.prototype.filter.call(n, function (e) {
                                                            return "A" === e.tagName || 3 !== e.nodeType && e.querySelector("a")
                                                        })[0];
                                                        i ? (r = J.clone(i, !1, !0)).classList.add("nav-item") : r = J.createElement(e.subnav.length ? "a" : "span", {
                                                            class: "nav-item"
                                                        }, Array.prototype.map.call(n, function (e) {
                                                            return J.clone(e, !0, !0)
                                                        })), "A" === r.tagName && (r.setAttribute("tabindex", "0"), r.setAttribute("role", "menuitem"), r.getAttribute("href") || r.setAttribute("href", "#")), i && r.addEventListener("click", function (e) {
                                                            e.stopPropagation(), J.hasListener(i, "click") && i.click()
                                                        }), "#" === r.getAttribute("href") && r.addEventListener("click", J.preventDefault), R.closeOnClick && (z() ? "A" !== r.tagName || "false" === r.dataset.navClose || null !== r.getAttribute("disabled") && "false" !== r.getAttribute("disabled") || e.subnav.length && (!r.getAttribute("href") || "#" === r.getAttribute("href").charAt(0)) || r.addEventListener("click", Y) : "A" !== r.tagName || "false" === r.dataset.navClose || null !== r.getAttribute("disabled") && "false" !== r.getAttribute("disabled") || r.addEventListener("click", Y));
                                                        var s = J.createElement("li");
                                                        if (s.appendChild(r), h.appendChild(s), R.keepClasses && e.classes && (s.className = e.classes), e.highlight && s.classList.add("nav-highlight"), J.wrap(r, J.createElement("div", {
                                                            class: "nav-item-wrapper"
                                                        })), R.levelSpacing && ("expand" === R.levelOpen || !1 === R.levelOpen || "none" === R.levelOpen)) {
                                                            var o = R.levelSpacing * y;
                                                            o && (h.style.textIndent = o + "px")
                                                        }
                                                        if (e.subnav.length) {
                                                            var l = y + 1,
                                                                    c = e.id,
                                                                    v = "";
                                                            if (A[l] || (A[l] = 0), s.classList.add("nav-parent"), z()) {
                                                                var u = A[l],
                                                                        d = J.createElement("input", {
                                                                            type: "checkbox",
                                                                            id: E + "-" + l + "-" + u,
                                                                            class: "hc-chk",
                                                                            tabindex: -1,
                                                                            "data-level": l,
                                                                            "data-index": u,
                                                                            value: c
                                                                        });
                                                                d.addEventListener("click", J.stopPropagation), d.addEventListener("change", W), s.insertBefore(d, s.firstChild);
                                                                var p = function (e) {
                                                                    e.addEventListener("click", function (e) {
                                                                        if (e.stopPropagation(), d.setAttribute("checked", "true" !== d.getAttribute("checked")), "createEvent" in ae) {
                                                                            var t = ae.createEvent("HTMLEvents");
                                                                            t.initEvent("change", !1, !0), d.dispatchEvent(t)
                                                                        }
                                                                    }), e.addEventListener("keydown", function (e) {
                                                                        "Enter" !== e.key && 13 !== e.keyCode || (C = !0, k.push(this))
                                                                    }), e.setAttribute("aria-controls", "menu-" + c), e.setAttribute("aria-haspopup", "overlap" === R.levelOpen), e.setAttribute("aria-expanded", !1)
                                                                };
                                                                if (-1 !== x.indexOf(c) && (g.classList.add("sub-level-open"), g.addEventListener("click", function () {
                                                                    return $(l, u)
                                                                }), s.classList.add("level-open"), d.setAttribute("checked", !0)), v = !0 === R.levelTitles ? n[0].textContent.trim() : "", r.getAttribute("href") && "#" !== r.getAttribute("href")) {
                                                                    var f = J.createElement("a", {
                                                                        href: "#",
                                                                        class: "nav-next",
                                                                        "aria-label": (R.ariaLabels || {}).submenu + ": " + v,
                                                                        role: "menuitem",
                                                                        tabindex: 0
                                                                    }, J.createElement("span"));
                                                                    f.addEventListener("click", J.preventClick()), r.parentNode.insertBefore(f, r.nextSibling), p(f)
                                                                } else
                                                                    r.appendChild(J.createElement("span", {
                                                                        class: "nav-next"
                                                                    }, J.createElement("span"))), p(r)
                                                            } else
                                                                r.setAttribute("aria-expanded", !0);
                                                            A[l]++, m(e.subnav, s, l, v, A[l] - 1, b)
                                                        }
                                                    })
                                                });
                                                if (y && void 0 !== n && !1 !== R.insertBack && "overlap" === R.levelOpen) {
                                                    var i = J.children(r, "ul"),
                                                            s = R.levelTitleAsBack && a || R.labelBack || "",
                                                            o = J.createElement("a", {
                                                                href: "#",
                                                                role: "menuitem",
                                                                tabindex: 0
                                                            }, [s, J.createElement("span")]),
                                                            l = J.createElement("li", {
                                                                class: "nav-back"
                                                            }, o),
                                                            c = function () {
                                                                return $(y, n)
                                                            };
                                                    J.wrap(o, J.createElement("div", {
                                                        class: "nav-item-wrapper"
                                                    })), o.addEventListener("click", J.preventClick(c)), o.addEventListener("keydown", function (e) {
                                                        "Enter" !== e.key && 13 !== e.keyCode || (C = !0)
                                                    }), !0 === R.insertBack ? i[0].insertBefore(l, i[0].firstChild) : J.isNumeric(R.insertBack) && J.insertAt(l, R.insertBack, i)
                                                }
                                                if (0 === y && !1 !== R.insertClose) {
                                                    var v = J.children(r, "ul"),
                                                            u = J.createElement("a", {
                                                                href: "#",
                                                                role: "menuitem",
                                                                tabindex: 0
                                                            }, "object" == typeof R.labelClose ? J.getElement(R.labelClose) : [R.labelClose || "", J.createElement("span")]),
                                                            d = J.createElement("li", {
                                                                class: "nav-close"
                                                            }, u);
                                                    R.labelClose && "" !== R.labelClose || u.setAttribute("aria-label", (R.ariaLabels || {}).close), J.wrap(u, J.createElement("div", {
                                                        class: "nav-item-wrapper"
                                                    })), u.addEventListener("click", J.preventClick(Y)), u.addEventListener("keydown", function (e) {
                                                        "Enter" !== e.key && 13 !== e.keyCode || S()
                                                    }), !0 === R.insertClose ? v[0].insertBefore(d, v[0].firstChild) : J.isNumeric(R.insertClose) && J.insertAt(d, R.insertClose, v)
                                                }
                                            }(a, v, 0, R.navTitle)
                                        },
                                        _ = function (t) {
                                            return function (e) {
                                                "left" !== R.position && "right" !== R.position || (l = e.touches[0].clientX, O = e.touches[0].clientY, "doc" === t ? T || (ae.addEventListener("touchmove", q, J.supportsPassive), ae.addEventListener("touchend", D, J.supportsPassive)) : (T = !0, v.addEventListener("touchmove", H, J.supportsPassive), v.addEventListener("touchend", I, J.supportsPassive)))
                                            }
                                        },
                                        j = function (e, t) {
                                            ne.addEventListener("touchmove", J.preventDefault, J.supportsPassive), c.style.visibility = "visible", v.style[J.browserPrefix("transition")] = "none", J.setTransform(v, e, R.position), p && (p.style[J.browserPrefix("transition")] = "none", J.setTransform(p, t, R.position))
                                        },
                                        B = function (e, t, n, a) {
                                            void 0 === t && (t = !0), void 0 === n && (n = !1), void 0 === a && (a = !1), ne.removeEventListener("touchmove", J.preventDefault, J.supportsPassive), v.style[J.browserPrefix("transition")] = "", J.setTransform(v, n, R.position), p && (p.style[J.browserPrefix("transition")] = "", J.setTransform(p, a, R.position)), "open" === e ? V() : (Y(), t ? setTimeout(function () {
                                                c.style.visibility = ""
                                            }, u) : c.style.visibility = "")
                                        },
                                        q = function (e) {
                                            var t = 0 - (l - e.touches[0].clientX),
                                                    n = "overlap" === R.levelOpen ? F() * R.levelSpacing : 0,
                                                    a = b + n;
                                            t = "left" === R.position ? Math.min(Math.max(t, 0), a) : Math.abs(Math.min(Math.max(t, -a), 0)), ("left" === R.position && l < 50 || "right" === R.position && l > ae.clientWidth - 50) && (N = !0, j(0 - (b - t), Math.abs(t)))
                                        },
                                        D = function e(t) {
                                            if (ae.removeEventListener("touchmove", q), ae.removeEventListener("touchend", e), N) {
                                                var n = t.changedTouches[t.changedTouches.length - 1],
                                                        a = 0 - (l - n.clientX),
                                                        r = "overlap" === R.levelOpen ? F() * R.levelSpacing : 0,
                                                        i = b + r;
                                                (a = "left" === R.position ? Math.min(Math.max(a, 0), i) : Math.abs(Math.min(Math.max(a, -i), 0))) ? B(70 < a ? "open" : "close") : B("close", !1), O = l = null, N = !1
                                            }
                                        },
                                        H = function (e) {
                                            var t = 0 - (l - e.touches[0].clientX),
                                                    n = 0 - (O - e.touches[0].clientY);
                                            if (!(Math.abs(t) < Math.abs(n))) {
                                                var a = "overlap" === R.levelOpen ? F() * R.levelSpacing : 0,
                                                        r = b + a;
                                                t = "left" === R.position ? Math.min(Math.max(t, -r), 0) : Math.min(Math.max(t, 0), r), ("left" === R.position && t < 0 || "right" === R.position && 0 < t) && (N = !0, j(-Math.abs(t) + a, r - Math.abs(t)))
                                            }
                                        },
                                        I = function e(t) {
                                            if (v.removeEventListener("touchmove", H), v.removeEventListener("touchend", e), T = !1, N) {
                                                var n = t.changedTouches[t.changedTouches.length - 1],
                                                        a = 0 - (l - n.clientX),
                                                        r = "overlap" === R.levelOpen ? F() * R.levelSpacing : 0,
                                                        i = b + r;
                                                (a = "left" === R.position ? Math.abs(Math.min(Math.max(a, -i), 0)) : Math.abs(Math.min(Math.max(a, 0), i))) === i ? B("close", !1) : 50 < a ? B("close") : B("open", !0, r, i), O = l = null, N = !1
                                            }
                                        };
                                r(), i(), P(),
                                        !0 === R.removeOriginalNav ? e.parentNode.removeChild(e) : e.classList.add("hc-nav-original", E),
                                        //HQ
                                        "none" === R.bodyInsert ? e.insertAdjacentElement("afterend", c) : ("prepend" === R.bodyInsert ? ae.body.insertBefore(c, ae.body.firstChild) : "append" === R.bodyInsert && ae.body.appendChild(c)),
                                        !0 === R.expanded && (h = !0, V()), R.swipeGestures && (v.addEventListener("touchstart", _("nav"), J.supportsPassive), ae.addEventListener("touchstart", _("doc"), J.supportsPassive)), ae.addEventListener("keydown", function (e) {
                                    if (X() && ("Escape" === e.key || 27 === e.keyCode)) {
                                        var t = F();
                                        0 === t ? (Y(), S()) : ($(t, Q()), w(null, t - 1))
                                    }
                                });
                                var U = function (e, t, n) {
                                    var a = ae.querySelector("#" + E + "-" + e + "-" + t);
                                    if (a) {
                                        var r = a.value,
                                                i = a.parentNode,
                                                s = i.closest(".nav-wrapper");
                                        if (a.setAttribute("checked", !1), s.classList.remove("sub-level-open"), i.classList.remove("level-open"), i.querySelectorAll("[aria-controls]")[0].setAttribute("aria-expanded", !1), -1 !== x.indexOf(r) && x.splice(x.indexOf(r), 1), n && "overlap" === R.levelOpen && (s.removeEventListener("click"), s.addEventListener("click", J.stopPropagation), J.setTransform(v, (e - 1) * R.levelSpacing, R.position), p)) {
                                            var o = "x" === J.getAxis(R.position) ? b : g;
                                            J.setTransform(p, o + (e - 1) * R.levelSpacing, R.position)
                                        }
                                    }
                                };
                                return c.on = function (e, t) {
                                    c.addEventListener(e, t)
                                }, c.off = function (e, t) {
                                    c.removeEventListener(e, t)
                                }, c.getSettings = function () {
                                    return Object.assign({}, R)
                                }, c.isOpen = X, c.open = V, c.close = Y, c.update = function (e, t) {
                                    if (Z = [], "object" == typeof e) {
                                        for (var n in e)
                                            R[n] !== e[n] && Z.push(n);
                                        R = Object.assign({}, R, e)
                                    }
                                    if (!0 === e || !0 === t) {
                                        if (R.removeOriginalNav)
                                            return void console.warn("%c! HC Offcanvas Nav:%c Can't update because original navigation has been removed. Disable `removeOriginalNav` option.", "color: #fa253b", "color: default");
                                        r(!0), i(), P(!0)
                                    } else
                                        r(!0), P(!0)
                                }, c
                            }

                            function W() {
                                var e = Number(this.dataset.level),
                                        t = Number(this.dataset.index);
                                "true" === this.getAttribute("checked") ? K(e, t) : $(e, t)
                            }

                            function z() {
                                return !1 !== R.levelOpen && "none" !== R.levelOpen
                            }

                            function X() {
                                return f
                            }

                            function F() {
                                return x.length ? Number(Array.prototype.filter.call(v.querySelectorAll(".hc-chk"), function (e) {
                                    return e.value == x[x.length - 1]
                                })[0].dataset.level) : 0
                            }

                            function Q() {
                                return x.length ? Number(Array.prototype.filter.call(v.querySelectorAll(".hc-chk"), function (e) {
                                    return e.value == x[x.length - 1]
                                })[0].dataset.index) : 0
                            }

                            function V(e, t) {
                                if ((!X() || void 0 !== t) && (function () {
                                    if (X())
                                        return;
                                    f = !0, c.style.visibility = "visible", c.setAttribute("aria-hidden", !1), c.classList.add(ee), d.classList.add("toggle-open"), "expand" === R.levelOpen && L && clearTimeout(L);
                                    R.disableBody && (y = ne.pageYOffset || re.scrollTop || ae.documentElement.scrollTop || ae.body.scrollTop, J.hasScrollBar() && re.classList.add("hc-nav-yscroll"), ae.body.classList.add("hc-nav-open"), y && (ae.body.style.top = -y + "px"));
                                    if (p) {
                                        var e = "x" === J.getAxis(R.position) ? b : g;
                                        J.setTransform(p, e, R.position)
                                    }
                                    if (h)
                                        return h = !1;
                                    setTimeout(function () {
                                        c._eventListeners.open && c._eventListeners.open.forEach(function (e) {
                                            e.fn(J.customEventObject("open", c, c), Object.assign({}, R))
                                        })
                                    }, u)
                                }(), z())) {
                                    var n;
                                    if ("number" != typeof e && !J.isNumeric(e) || "number" != typeof t && !J.isNumeric(t))
                                        m ? (n = Array.prototype.filter.call(v.querySelectorAll(".hc-chk"), function (e) {
                                            return e.value == m
                                        })[0], !R.closeActiveLevel && R.closeOpenLevels || (m = null)) : !1 === R.closeOpenLevels && (n = (n = Array.prototype.filter.call(v.querySelectorAll(".hc-chk"), function (e) {
                                            return "true" === e.getAttribute("checked")
                                        }))[n.length - 1]);
                                    else if (!(n = ae.querySelector("#" + E + "-" + e + "-" + t)))
                                        return void console.warn("HC Offcanvas Nav: level " + e + " doesn't have index " + t);
                                    if (n) {
                                        var a = [];
                                        if (e = Number(n.dataset.level), t = Number(n.dataset.index), 1 < e) {
                                            for (var r = []; n && n !== ae; n = n.parentNode)
                                                n.matches(".nav-wrapper") && r.push(n);
                                            for (var i = 0; i < r.length; i++) {
                                                var s = r[i],
                                                        o = Number(s.dataset.level);
                                                0 < o && a.push({
                                                    level: o,
                                                    index: Number(s.dataset.index)
                                                })
                                            }
                                            a = a.reverse()
                                        }
                                        a.push({
                                            level: e,
                                            index: t
                                        });
                                        for (var l = 0; l < a.length; l++)
                                            K(a[l].level, a[l].index, !1)
                                    }
                                }
                            }

                            function Y() {
                                if (X()) {
                                    if (f = !1, p && J.setTransform(p, !1), c.classList.remove(ee), c.setAttribute("aria-hidden", !0), v.removeAttribute("style"), d.classList.remove("toggle-open"), "expand" === R.levelOpen && -1 !== ["top", "bottom"].indexOf(R.position) ? $(0) : z() && (L = setTimeout(function () {
                                        $(0)
                                    }, "expand" === R.levelOpen ? u : 0)), R.disableBody && (ae.body.classList.remove("hc-nav-open"), re.classList.remove("hc-nav-yscroll"), y)) {
                                        if (ae.body.style.top = "", ae.body.scrollTop = y, re.scrollTop = y, "bottom" === R.position) {
                                            var e = y;
                                            setTimeout(function () {
                                                ae.body.scrollTop = e, re.scrollTop = e
                                            }, 0)
                                        }
                                        y = 0
                                    }
                                    setTimeout(function () {
                                        c.style.visibility = "", c._eventListeners.close && c._eventListeners.close.forEach(function (e) {
                                            e.fn(J.customEventObject("close", c, c), Object.assign({}, R))
                                        }), c._eventListeners["close.once"] && c._eventListeners["close.once"].forEach(function (e) {
                                            e.fn(J.customEventObject("close.once", c, c), Object.assign({}, R))
                                        }), c.removeEventListener("close.once")
                                    }, u)
                                }
                            }

                            function G(e) {
                                e.preventDefault(), e.stopPropagation(), f ? Y() : V()
                            }

                            function K(t, n, e) {
                                void 0 === e && (e = !0);
                                var a = ae.querySelector("#" + E + "-" + t + "-" + n),
                                        r = a.value,
                                        i = a.parentNode,
                                        s = i.closest(".nav-wrapper"),
                                        o = J.children(i, ".nav-wrapper")[0];
                                if (!1 === e && (o.style.transition = "none"), a.setAttribute("checked", !0), s.classList.add("sub-level-open"), i.classList.add("level-open"), i.querySelectorAll("[aria-controls]")[0].setAttribute("aria-expanded", !0), !1 === e && setTimeout(function () {
                                    o.style.transition = ""
                                }, u), -1 === x.indexOf(r) && x.push(r), "overlap" === R.levelOpen && (s.addEventListener("click", function () {
                                    return $(t, n)
                                }), J.setTransform(v, t * R.levelSpacing, R.position), p)) {
                                    var l = "x" === J.getAxis(R.position) ? b : g;
                                    J.setTransform(p, l + t * R.levelSpacing, R.position)
                                }
                                c._eventListeners["open.level"] && c._eventListeners["open.level"].forEach(function (e) {
                                    e.fn(J.customEventObject("open.level", c, o, {
                                        currentLevel: t,
                                        currentIndex: n
                                    }), Object.assign({}, R))
                                }), C && (w(0, t, n), C = !1)
                            }

                            function $(t, e) {
                                for (var n = t; n <= Object.keys(A).length; n++)
                                    if (n === t && void 0 !== e)
                                        U(t, e, !0);
                                    else if (0 !== t || R.closeOpenLevels)
                                        for (var a = 0; a < A[n]; a++)
                                            U(n, a, n === t);
                                    else
                                        ;
                                if (0 < t && c._eventListeners["close.level"]) {
                                    var r = ae.querySelector("#" + E + "-" + t + "-" + e).closest(".nav-wrapper");
                                    c._eventListeners["close.level"].forEach(function (e) {
                                        e.fn(J.customEventObject("close.level", c, r, {
                                            currentLevel: t - 1,
                                            currentIndex: Q()
                                        }), Object.assign({}, R))
                                    })
                                }
                                C && (w(null, t - 1), C = !1)
                            }
                            console.error("%c! HC Offcanvas Nav:%c Menu must contain <ul> element.", "color: #fa253b", "color: default")
                        };
                if (Array.isArray(e) || e instanceof NodeList) {
                    for (var a = [], r = 0; r < e.length; r++)
                        a.push(n(e[r]));
                    return 1 < a.length ? a : a[0]
                }
                return n(e)
            };
    if (void 0 !== ne.jQuery) {
        var n = ne.jQuery,
                a = "hcOffcanvasNav";
        n.fn.extend({
            hcOffcanvasNav: function (t) {
                return this.length ? this.each(function () {
                    var e = n.data(this, a);
                    e ? e.update(t) : (e = new i(this, t), n.data(this, a, e))
                }) : this
            }
        })
    }
    return ne.hcOffcanvasNav = ne.hcOffcanvasNav || i, i
}),
        function (n) {
            var e = n.hcOffcanvasNav,
                    o = n.document,
                    t = !1;
            try {
                var a = Object.defineProperty({}, "passive", {
                    get: function () {
                        t = {
                            passive: !1
                        }
                    }
                });
                n.addEventListener("testPassive", null, a), n.removeEventListener("testPassive", null, a)
            } catch (e) {
            }
            Element.prototype.closest || (Element.prototype.closest = function (e) {
                var t = this;
                do {
                    if (Element.prototype.matches.call(t, e))
                        return t;
                    t = t.parentElement || t.parentNode
                } while (null !== t && 1 === t.nodeType);
                return null
            }), Array.prototype.flat || Object.defineProperty(Array.prototype, "flat", {
                configurable: !0,
                value: function n() {
                    var a = isNaN(arguments[0]) ? 1 : Number(arguments[0]);
                    return a ? Array.prototype.reduce.call(this, function (e, t) {
                        return Array.isArray(t) ? e.push.apply(e, n.call(t, a - 1)) : e.push(t), e
                    }, []) : Array.prototype.slice.call(this)
                },
                writable: !0
            }), Element.prototype.matches || (Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.matchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.oMatchesSelector || Element.prototype.webkitMatchesSelector);
            var r = (/iPad|iPhone|iPod/.test(navigator.userAgent) || !!navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform)) && !n.MSStream,
                    i = "ontouchstart" in n || navigator.maxTouchPoints || n.DocumentTouch && o instanceof DocumentTouch,
                    s = function (e) {
                        return !isNaN(parseFloat(e)) && isFinite(e)
                    },
                    l = function (e) {
                        var t = ["Webkit", "Moz", "Ms", "O"],
                                n = (o.body || o.documentElement).style,
                                a = e.charAt(0).toUpperCase() + e.slice(1);
                        if (void 0 !== n[e])
                            return e;
                        for (var r = 0; r < t.length; r++)
                            if (void 0 !== n[t[r] + a])
                                return t[r] + a;
                        return !1
                    },
                    c = function (e, t) {
                        if (e instanceof Element)
                            return t ? Array.prototype.filter.call(e.children, function (e) {
                                return e.matches(t)
                            }) : e.children;
                        var n = [];
                        return Array.prototype.forEach.call(e, function (e) {
                            n = t ? n.concat(Array.prototype.filter.call(e.children, function (e) {
                                return e.matches(t)
                            })) : n.concat(Array.prototype.slice.call(e.children))
                        }), n
                    },
                    v = function (o, e) {
                        var l = EventTarget.prototype[o + "EventListener"];
                        return function (e, t, n) {
                            if (this) {
                                var a = e.split(".")[0];
                                if (this._eventListeners = this._eventListeners || {}, "add" === o) {
                                    this._eventListeners[e] = this._eventListeners[e] || [];
                                    var r = {
                                        fn: t
                                    };
                                    n && (r.options = n), this._eventListeners[e].push(r), l.call(this, a, t, n)
                                } else if ("function" == typeof t)
                                    for (var i in l.call(this, a, t, n), this._eventListeners)
                                        this._eventListeners[i] = this._eventListeners[i].filter(function (e) {
                                            return e.fn !== t
                                        }), this._eventListeners[i].length || delete this._eventListeners[i];
                                else if (this._eventListeners[e]) {
                                    for (var s = this._eventListeners[e].length; s--; )
                                        l.call(this, a, this._eventListeners[e][s].fn, this._eventListeners[e][s].options), this._eventListeners[e].splice(s, 1);
                                    this._eventListeners[e].length || delete this._eventListeners[e]
                                }
                            }
                        }
                    };
            EventTarget.prototype.addEventListener = v("add"), EventTarget.prototype.removeEventListener = v("remove");
            var u, d = function (e, t, n) {
                void 0 === t && (t = {});
                var a = o.createElement(e);
                for (var r in t)
                    "class" !== r ? a.setAttribute(r, t[r]) : a.className = t[r];
                if (n) {
                    Array.isArray(n) || (n = [n]);
                    for (var i = 0; i < n.length; i++)
                        if ("object" == typeof n[i] && n[i].length && !n[i].nodeType)
                            for (var s = 0; s < n[i].length; s++)
                                a.appendChild(n[i][s]);
                        else
                            a.appendChild("string" == typeof n[i] ? o.createTextNode(n[i]) : n[i])
                }
                return a
            },
                    p = function (e) {
                        return -1 !== ["left", "right"].indexOf(e) ? "x" : "y"
                    },
                    f = (u = l("transform"), function (e, t, n) {
                        if (u)
                            if (!1 === t || "" === t)
                                e.style.transform = "";
                            else if ("x" === p(n)) {
                                var a = "left" === n ? t : 0 - t;
                                e.style.transform = "translate3d(" + a + "px,0,0)"
                            } else {
                                var r = "top" === n ? t : 0 - t;
                                e.style.transform = "translate3d(0," + r + "px,0)"
                            }
                        else
                            e.style.position = t
                    }),
                    h = function (e, t, n) {
                        console.warn("%cHC Off-canvas Nav:%c " + n + "%c '" + e + "'%c is now deprecated and will be removed in the future. Use%c '" + t + "'%c option instead. See details about plugin usage at https://github.com/somewebmedia/hc-offcanvas-nav.", "color: #fa253b", "color: default", "color: #5595c6", "color: default", "color: #5595c6", "color: default")
                    };
            e.Helpers = {
                supportsPassive: t,
                hasScrollBar: function () {
                    return o.documentElement.scrollHeight > o.documentElement.clientHeight
                },
                isIos: r,
                isTouchDevice: i,
                isNumeric: s,
                formatSizeVal: function (e) {
                    return "auto" === e ? e : s(e) ? e + "px" : e
                },
                toMs: function (e) {
                    return parseFloat(e) * (/\ds$/.test(e) ? 1e3 : 1)
                },
                stopPropagation: function (e) {
                    return e.stopPropagation()
                },
                preventDefault: function (e) {
                    return e.preventDefault()
                },
                preventClick: function (t) {
                    return function (e) {
                        e.preventDefault(), e.stopPropagation(), "function" == typeof t && t()
                    }
                },
                browserPrefix: l,
                children: c,
                wrap: function (e, t) {
                    e.parentNode.insertBefore(t, e), t.appendChild(e)
                },
                data: function (e, t, n) {
                    if (e.hcOffcanvasNav = e.hcOffcanvasNav || {}, void 0 === n)
                        return e.hcOffcanvasNav[t];
                    e.hcOffcanvasNav[t] = n
                },
                clone: function (e, t, n) {
                    var a = e.cloneNode(n || !1),
                            r = e instanceof Element ? [e].concat(Array.prototype.slice.call(e.getElementsByTagName("*"))) : [],
                            i = a instanceof Element ? [a].concat(Array.prototype.slice.call(a.getElementsByTagName("*"))) : [];
                    return t || (r.shift(), i.shift()), n && function (e, t) {
                        for (var n = 0; n < e.length; n++)
                            if (e[n]._eventListeners)
                                for (var a in e[n]._eventListeners)
                                    for (var r = 0; r < e[n]._eventListeners[a].length; r++)
                                        t[r].addEventListener(a, e[n]._eventListeners[a][r].fn, e[n]._eventListeners[a][r].options)
                    }(r, i), a
                },
                customEventObject: function (e, n, a, r) {
                    return new function (e) {
                        for (var t in this.bubbles = !1, this.cancelable = !1, this.composed = !1, this.currentTarget = a, this.data = r ? {} : null, this.defaultPrevented = !1, this.eventPhase = 0, this.isTrusted = !1, this.target = n, this.timeStamp = Date.now(), this.type = e, r)
                            this.data[t] = r[t]
                    }(e)
                },
                hasListener: function (e, t) {
                    return (t ? (e._eventListeners || {})[t] : e._eventListeners) || !1
                },
                createElement: d,
                getElement: function (e) {
                    var t = null;
                    return "string" == typeof e ? t = o.querySelector(e) : n.jQuery && e instanceof n.jQuery && e.length ? t = e[0] : e instanceof Element && (t = e), t
                },
                getElementCssTag: function e(t) {
                    return "string" == typeof t ? t : t.getAttribute("id") ? "#" + t.getAttribute("id") : t.getAttribute("class") ? t.tagName.toLowerCase() + "." + t.getAttribute("class").replace(/\s+/g, ".") : e(t.parentNode) + " > " + t.tagName.toLowerCase()
                },
                printStyle: function (e) {
                    var r = d("style", {
                        id: e
                    }),
                            i = {},
                            s = {};
                    o.head.appendChild(r);
                    var a = function (e) {
                        return ";" !== e.substr(-1) && (e += ";" !== e.substr(-1) ? ";" : ""), e
                    };
                    return {
                        reset: function () {
                            i = {}, s = {}
                        },
                        add: function (e, t, n) {
                            e = e.trim(), t = t.trim(), n ? (n = n.trim(), s[n] = s[n] || {}, s[n][e] = a(t)) : i[e] = a(t)
                        },
                        remove: function (e, t) {
                            e = e.trim(), t ? (t = t.trim(), void 0 !== s[t][e] && delete s[t][e]) : void 0 !== i[e] && delete i[e]
                        },
                        insert: function () {
                            var e = "";
                            for (var t in s) {
                                for (var n in e += "@media screen and (" + t + ") {\n", s[t])
                                    e += n + " { " + s[t][n] + " }\n";
                                e += "}\n"
                            }
                            for (var a in i)
                                e += a + " { " + i[a] + " }\n";
                            r.innerHTML = e
                        }
                    }
                },
                insertAt: function (e, t, n) {
                    var a = c(n),
                            r = a.length,
                            i = -1 < t ? Math.max(0, Math.min(t - 1, r)) : Math.max(0, Math.min(r + t + 1, r));
                    0 === i ? n.insertBefore(e, n.firstChild) : a[i - 1].insertAdjacentElement("afterend", e)
                },
                getAxis: p,
                setTransform: f,
                deprecated: h
            }
        }(window);