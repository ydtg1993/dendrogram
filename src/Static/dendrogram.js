(function (window) {

    'use strict';

    var dendrogram = {
        icon_data: {
            'expand': '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"></line> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg>',
            'shrink': '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"></line></svg>',
            'grow': '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="social"><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7"></line><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8"></line><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3"></circle></svg>',
            'ban': '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"></circle><line fill="none" stroke="#fff" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"></line></svg>'
        },
        requestEvent: function (url, data, method, callback) {
            method = typeof method !== 'undefined' ? method : 'POST';
            callback = typeof callback == 'function' ? callback : function (d) {
            };

            var xhr = null;
            if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } else if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }

            if (xhr == null) {
                return;
            }
            xhr.open(method, url, true);
            if (method == 'POST') {
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            }
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.reload();
                    callback(xhr.responseText);
                }
            };

            xhr.send(JSON.stringify(data));
        },
        bindClassEnvent: function (className, event, func) {
            var objs = document.getElementsByClassName(className);
            for (var i = 0; i < objs.length; i++) {
                objs[i].addEventListener(event, func, false);
            }
        },
        removeChildDom: function (dom) {
            while (dom.hasChildNodes()) {
                dom.removeChild(dom.firstChild);
            }
        },
        appendChildDom: function (dom, html) {
            dom.innerHTML = html;
        },
        relpaceChild: function (dom, html) {
            dendrogram.removeChildDom(dom);
            dendrogram.appendChildDom(dom, html);
        },
        getInput: function (name) {
            var elements = document.getElementsByName(name);
            return elements[0];
        },
        tree: {
            id: 0,
            conserve_action:'add',
            form_action: '%s',
            tabAnimeFlag: false,
            tabAnimeErroNum: 0,
            init: function () {
                dendrogram.bindClassEnvent('dendrogram-tab', 'click', dendrogram.tree.tab);
                dendrogram.bindClassEnvent('dendrogram-button', 'click', dendrogram.tree.upForm);
                dendrogram.bindClassEnvent('dendrogram-grow', 'click', dendrogram.tree.addForm);
                document.getElementById('mongolia').onclick = function () {
                    dendrogram.tree.mongolia(false);
                };
                document.getElementById('dendrogram-form-close').onclick = function () {
                    dendrogram.tree.mongolia(false);
                };
                dendrogram.bindClassEnvent('dendrogram-form-delete', 'click', dendrogram.tree.delete);
                dendrogram.bindClassEnvent('dendrogram-form-conserve', 'click', dendrogram.tree.conserve);
            },
            mongolia: function (flag) {
                if (flag) {
                    document.getElementById('mongolia').setAttribute('style', 'display:block;opacity:1');
                    setTimeout(function () {
                        document.getElementById('dendrogram-form').setAttribute('style', 'visibility: visible;opacity:1');
                    }, 0);
                    return;
                }
                document.getElementById('mongolia').setAttribute('style', 'display:none;opacity:0');
                document.getElementById('dendrogram-form').setAttribute('style', 'visibility: hidden;opacity:0');
            },
            addForm: function () {
                dendrogram.tree.mongolia(true);
                document.getElementById('dendrogram-form-theme').innerText = '增加节点';
                var delete_buttun = document.getElementsByClassName('dendrogram-form-delete');
                if (delete_buttun[0] instanceof HTMLElement) {
                    delete_buttun[0].setAttribute('style', 'display:none;');
                }

                var data = this.parentNode.getAttribute('data-v');
                var data = JSON.parse(data);
                for (var name in data) {
                    var item = dendrogram.getInput(name);
                    if ((item instanceof HTMLElement) == false) {
                        continue;
                    }
                    console.log(data[name])
                    if(typeof(data[name]) == "number"){
                        item.value = 0;
                    }else {
                        item.value = '';
                    }
                    item.placeholder = name;
                }
                dendrogram.tree.id = data.id;
                dendrogram.tree.conserve_action = 'add';
            },
            upForm: function () {
                dendrogram.tree.mongolia(true);
                document.getElementById('dendrogram-form-theme').innerText = '修改节点';
                var delete_buttun = document.getElementsByClassName('dendrogram-form-delete');
                if (delete_buttun[0] instanceof HTMLElement) {
                    delete_buttun[0].setAttribute('style', 'display:inline-block;');
                }

                var data = this.parentNode.getAttribute('data-v');
                var data = JSON.parse(data);
                for (var name in data) {
                    var item = dendrogram.getInput(name);
                    if ((item instanceof HTMLElement) == false) {
                        continue;
                    }
                    if (data.hasOwnProperty(name)) {
                        item.value = data[name];
                    } else {
                        item.placeholder = name;
                    }
                }
                dendrogram.tree.id = data.id;
                dendrogram.tree.conserve_action = 'update';
            },
            conserve: function () {
                var elements = document.getElementsByTagName('input');

                if (dendrogram.tree.conserve_action === 'add') {
                    var data = {'p_id':dendrogram.tree.id};
                }else {
                    var data = {'id':dendrogram.tree.id};
                }
                for (var element in elements) {
                    if (elements[element] instanceof HTMLElement && elements[element].className == 'dendrogram-input') {
                        var name = elements[element].name;
                        var val = elements[element].value;
                        data[name] = val;
                    }
                }

                dendrogram.requestEvent(dendrogram.tree.form_action, {
                    'data': data,
                    'action': dendrogram.tree.conserve_action
                });
            },
            delete: function () {
                dendrogram.requestEvent(dendrogram.tree.form_action, {
                    'data': {'id': dendrogram.tree.id},
                    'action': 'delete'
                })
            },
            tab: function () {
                var node = this.parentNode;
                var sign = node.getAttribute('data-sign');
                var children = node.parentNode.childNodes[3];

                if (dendrogram.tree.shrinkAnimeFlag) {
                    if (dendrogram.tree.tabAnimeErroNum > 3) {
                        window.location.reload();
                    }
                    dendrogram.tree.tabAnimeErroNum++;
                    return;
                }
                dendrogram.tree.shrinkAnimeFlag = true;

                if (sign == 0) {//open
                    dendrogram.relpaceChild(this, dendrogram.icon_data.shrink);
                    node.setAttribute('data-sign', 1);
                    children.setAttribute('style', 'display:block');
                    children.classList.remove('dendrogram-animation-reverse');
                    children.classList.add('dendrogram-animation-slide-top-small');
                } else {//shut
                    dendrogram.relpaceChild(this, dendrogram.icon_data.expand);
                    node.setAttribute('data-sign', 0);
                    children.classList.remove('dendrogram-animation-slide-top-small');
                    var t = setTimeout(function () {
                        children.classList.add('dendrogram-animation-reverse');
                    }, 0);
                }

                children.addEventListener('animationend', function callback() {
                    if (sign == 1) {
                        children.setAttribute('style', 'display:none');
                        clearTimeout(t);
                    }
                    children.removeEventListener('animationend', callback);
                    dendrogram.tree.shrinkAnimeFlag = false;
                    dendrogram.tree.tabAnimeErroNum = 0;
                }, false);
            }
        }
    };

    if (typeof define === 'function' && define.amd) {
        // AMD
        define(dendrogram);
    } else {
        window.dendrogram = dendrogram;
    }
})(window);
