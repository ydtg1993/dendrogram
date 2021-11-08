(function (window) {

    'use strict';

    var dendrogram = {
        icon_data: {
            expand: '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"><\/circle> <line fill="none" stroke="#fff" x1="9.5" y1="5" x2="9.5" y2="14"><\/line> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"><\/line><\/svg>',
            shrink: '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"><\/circle> <line fill="none" stroke="#fff" x1="5" y1="9.5" x2="14" y2="9.5"><\/line><\/svg>',
            grow: '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" data-svg="social"><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7"></line><line fill="none" stroke="#fff" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8"><\/line><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3"></circle><circle fill="none" stroke="#fff" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3"><\/circle><\/svg>',
            ban: '<svg class="dendrogram-icon" width="14" height="14" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#fff" stroke-width="1.1" cx="9.5" cy="9.5" r="9"><\/circle><line fill="none" stroke="#fff" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5"><\/line><\/svg>'
        },
        requestEvent: function (url, params,form) {
            if(!url){
                return;
            }

            var xhr = null;
            if (window.ActiveXObject) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            } else if (window.XMLHttpRequest) {
                xhr = new XMLHttpRequest();
            }
            if (xhr == null) {
                return;
            }
            xhr.open('POST', url, true);
            xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            xhr.setRequestHeader('Cache-Control', 'no-cache');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = xhr.responseText;
                    if(form.conserve_action == 'delete'){
                        var dom = form.nodeElement;
                        dendrogram.removeChildrenDom(dom);
                        dom.parentNode.removeChild(dom)
                        return
                    }
                    if(form.conserve_action == 'update'){
                        var dom = form.nodeElement;
                        dom.setAttribute('data-v',JSON.stringify(params));
                        dom.children[1].children[0].innerText = params.name
                        form.mongolia(false);
                    }
                }
            };

            var formData = new FormData();
            formData.append('action',form.conserve_action)
            for(let k in params){
                formData.append('data['+k+']',params[k]);
            }
            xhr.send(formData);
        },
        bindClassEvent: function (className, event, func) {
            var objs = document.getElementsByClassName(className);
            for (var i = 0; i < objs.length; i++) {
                objs[i].addEventListener(event, func, false);
            }
        },
        removeChildrenDom: function (dom) {
            while (dom.hasChildNodes()) {
                dom.removeChild(dom.firstChild);
            }
        },
        replaceChild: function (dom, html) {
            dendrogram.removeChildrenDom(dom);
            dom.innerHTML = html;
        },
        sprint:function () {
            let args = arguments,string = args[0];
            for(let i = 1;i<args.length;i++){
                let item = arguments[i];
                string = string.replace('@s',item);
            }
            return string;
        },
        tree: {
            switchAnimeFlag: false,
            switchAnimeErroNum: 0,
            init: function () {
                dendrogram.bindClassEvent('dendrogram-switch', 'click', dendrogram.tree.switch);
                if(!dendrogram.form.form_action){
                    return
                }
                dendrogram.form.init();
            },
            switch: function () {
                var node = this.parentNode;
                var sign = node.getAttribute('data-sign');
                var children = node.parentNode.childNodes[3];

                if (dendrogram.tree.shrinkAnimeFlag) {
                    if (dendrogram.tree.switchAnimeErroNum > 3) {
                        window.location.reload();
                    }
                    dendrogram.tree.switchAnimeErroNum++;
                    return;
                }
                dendrogram.tree.shrinkAnimeFlag = true;

                if (sign == 0) {//open
                    dendrogram.replaceChild(this, dendrogram.icon_data.shrink);
                    node.setAttribute('data-sign', 1);
                    children.setAttribute('style', 'display:block');
                    children.classList.remove('dendrogram-animation-reverse');
                    children.classList.add('dendrogram-animation-slide-top-small');
                } else {//shut
                    dendrogram.replaceChild(this, dendrogram.icon_data.expand);
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
                    dendrogram.tree.switchAnimeErroNum = 0;
                }, false);
            }
        },
        form:{
            id:0,
            nodeElement:'',
            settings:[],
            conserve_action:'add',
            form_action: '%s',
            formContentTemplate:{
                input:'<div class="dendrogram-form-preference"><label>@s<\/label><input class="dendrogram-input" name="@s" value="@s" @s><\/div>',
                textarea:'<div class="dendrogram-form-preference"><label>@s<\/label><textarea class="dendrogram-textarea" rows="3" name="@s" @s\/>@s<\/textarea><\/div>',
                radio:'<label><input class="dendrogram-radio" type="radio" name="@s" value="@s" @s> @s<\/label>',
                checkbox:'<label><input class="dendrogram-checkbox" type="checkbox" name="@s" value="@s" @s> @s<\/label>'
            },
            init:function(){
                dendrogram.bindClassEvent('dendrogram-tab', 'click', dendrogram.form.upForm);
                dendrogram.bindClassEvent('dendrogram-grow', 'click', dendrogram.form.addForm);
                document.getElementById('mongolia').onclick = function () {
                    dendrogram.form.mongolia(false);
                };
                document.getElementById('dendrogram-form-close').onclick = function () {
                    dendrogram.form.mongolia(false);
                };
                dendrogram.bindClassEvent('dendrogram-form-delete', 'click', dendrogram.form.delete);
                dendrogram.bindClassEvent('dendrogram-form-conserve', 'click', dendrogram.form.conserve);
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
            initFormContent:function(data,isAdd = false){
                var data = JSON.parse(data);
                dendrogram.form.id = data.id;
                document.getElementById('dendrogram-form-body').innerHTML = '';
                var form_content_html = '';
                if(!Array.isArray(dendrogram.form.settings) || (dendrogram.form.settings.length == 0)){
                    //default
                    for(let key in data){
                        if(isAdd){
                            if (key == 'id'){
                                continue;
                            }
                            var template = dendrogram.sprint(dendrogram.form.formContentTemplate.input, key, key, '', '');
                            form_content_html+= template;
                            continue;
                        }
                        var template = dendrogram.sprint(dendrogram.form.formContentTemplate.input, key, key, data[key], '', '');
                        form_content_html+= template;
                    }
                    document.getElementById('dendrogram-form-body').innerHTML = form_content_html;
                }

                dendrogram.form.settings.forEach((setting) => {
                    if(!setting.column){
                        return;
                    }
                    var column = setting.column;
                    if(!data.hasOwnProperty(column)){
                        return;
                    }
                    for (let k in data){
                        data[k] = data[k].toString()
                    }
                    var label = setting.label ? setting.label : column;
                    var defaultValue = data.hasOwnProperty(column) ? data[column] : '';
                    var value = setting.value ? setting.value : defaultValue;
                    var type = setting.type ? setting.type : 'text';
                    var attribute = setting.attribute ? setting.attribute : '';
                    var options = setting.options ? setting.options : [];
                    if(isAdd){
                        value = '';
                        if(column == 'id'){
                            return;
                        }
                    }
                    form_content_html+= templateSelector(type,label, column, attribute,value,options);
                });

                document.getElementById('dendrogram-form-body').innerHTML = form_content_html;
                function templateSelector(type,label, column, attribute,value,options) {
                    switch (type) {
                        case "textarea":
                            return dendrogram.sprint(dendrogram.form.formContentTemplate.textarea, label, column, attribute, value);
                        case "radio":
                            var template = '';
                            for(let k in options){
                                var option = options[k];
                                if(!option.hasOwnProperty('label') || !option.hasOwnProperty('value')){
                                    continue;
                                }
                                if (option.value == value){
                                    template += dendrogram.sprint(dendrogram.form.formContentTemplate.radio,column, option.value, 'checked '+attribute,option.label);
                                    continue;
                                }
                                template += dendrogram.sprint(dendrogram.form.formContentTemplate.radio,column, option.value, attribute,option.label);
                            }
                            return '<div class="dendrogram-form-preference"><label style="display: block;">选择<\/label>'+template+'<\/div>';
                        case "checkbox":
                            value = value.toString();
                            var template = '';
                            for(let k in options){
                                var option = options[k];
                                if(!option.hasOwnProperty('label') || !option.hasOwnProperty('value')){
                                    continue;
                                }
                                var values = value.split(",");
                                if (values.indexOf(option.value.toString()) != -1){
                                    template += dendrogram.sprint(dendrogram.form.formContentTemplate.checkbox,column, option.value, 'checked '+attribute,option.label);
                                    continue;
                                }
                                template += dendrogram.sprint(dendrogram.form.formContentTemplate.checkbox,column, option.value, attribute,option.label);
                            }
                            return '<div class="dendrogram-form-preference"><label style="display: block;">选择<\/label>'+template+'<\/div>';
                        case "disable":
                            return dendrogram.sprint(dendrogram.form.formContentTemplate.input, label, column, value, 'disabled');
                        case "hidden":
                            var input = '<div><input class="dendrogram-input" name="@s" value="@s" type="hidden"><\/div>';
                            return dendrogram.sprint(input, label, column, value, 'type=disabled');
                        default:
                            return dendrogram.sprint(dendrogram.form.formContentTemplate.input, label, column, value, attribute);
                    }
                }
            },
            addForm: function () {
                dendrogram.form.conserve_action = 'add';
                document.getElementById('dendrogram-form-theme').innerText = '增添节点';
                var delete_buttun = document.getElementsByClassName('dendrogram-form-delete');
                if (delete_buttun[0] instanceof HTMLElement) {
                    delete_buttun[0].setAttribute('style', 'display:none;');
                }

                dendrogram.form.initFormContent(this.parentNode.getAttribute('data-v'),true);
                dendrogram.form.nodeElement = this.parentNode;
                dendrogram.form.mongolia(true);
            },
            upForm: function () {
                dendrogram.form.conserve_action = 'update';
                document.getElementById('dendrogram-form-theme').innerText = '修改节点';
                var delete_buttun = document.getElementsByClassName('dendrogram-form-delete');
                if (delete_buttun[0] instanceof HTMLElement) {
                    delete_buttun[0].setAttribute('style', 'display:inline-block;');
                }

                dendrogram.form.initFormContent(this.parentNode.getAttribute('data-v'));
                dendrogram.form.nodeElement = this.parentNode;
                dendrogram.form.mongolia(true);
            },
            conserve: function () {
                if (dendrogram.form.conserve_action === 'add') {
                    var data = {'p_id':dendrogram.form.id};
                }else {
                    var data = {'id':dendrogram.form.id};
                }

                data = insert_input_data(document.getElementsByClassName('dendrogram-input'),data);
                data = insert_input_data(document.getElementsByClassName('dendrogram-textarea'),data);
                data = insert_select_data(document.getElementsByClassName('dendrogram-radio'),data);
                data = insert_select_data(document.getElementsByClassName('dendrogram-checkbox'),data);

                dendrogram.requestEvent(dendrogram.form.form_action, data,dendrogram.form);
                function insert_input_data(elements,data){
                    for (var element in elements) {
                        if (elements[element] instanceof HTMLElement) {
                            var name = elements[element].name;
                            var val = elements[element].value;
                            data[name] = val;
                        }
                    }
                    return data;
                }
                function insert_select_data(elements,data){
                    for (var element in elements) {
                        if (elements[element] instanceof HTMLElement) {
                            var name = elements[element].name;
                            var options = document.getElementsByName(name);
                            if(elements[element].className == 'dendrogram-radio'){
                                for (var k in options) {
                                    if (options[k].checked) {
                                        data[name] = options[k].value;
                                        break;
                                    }
                                }
                                continue;
                            }
                            var check_box = [];
                            for (var k in options) {
                                if (options[k].checked) {
                                    check_box.push(options[k].value);
                                }
                            }
                            data[name] = check_box;
                        }
                    }
                    return data;
                }
            },
            delete: function () {
                dendrogram.form.conserve_action = 'delete';
                dendrogram.requestEvent(dendrogram.form.form_action, {id:dendrogram.form.id},dendrogram.form)
            },
        }
    };

    if (typeof define === 'function' && define.amd) {
        // AMD
        define(dendrogram);
    } else {
        window.dendrogram = dendrogram;
    }
})(window);
