(function (window) {

    'use strict';

    var dendrogramUS = {
        label:'%s',
        value:'%s',
        default:JSON.parse('%s'),
        storage:function () {
            var dom = document.getElementById('dendrogram-unlimited-select');
            var storage = [];
            for (var i = 0; i < dom.childNodes.length; i++) {
                var value = dom.childNodes[i].firstChild.valueOf().getAttribute('data-value');
                storage.push(value)
            }
            return storage;
        },
        callback:function(){

        },
        create: function (data) {
            var dom = document.getElementById('dendrogram-unlimited-select');
            if (!dom) {
                return
            }
            var ulDom = this.makeDropDown(data.children);
            if(!ulDom){
                return;
            }
            var box = document.createElement('div');
            var content = document.createElement('div');
            content.className = "dendrogram-select-button";
            var tag = "<svg style=\"vertical-align: middle;position: absolute;right:7px;top: 10px;\" width=\"20\" height=\"20\"\n" +
                "viewBox=\"0 0 20 20\" xmlns=\"http://www.w3.org/2000/svg\" data-svg=\"triangle-down\">\n" +
                "<polygon points=\"5 7 15 7 10 12\"></polygon></svg>";

            if(dendrogramUS.default.length <= 0){
                content.innerHTML = '<span>'+data.children[0][dendrogramUS.label]+'</span>'+tag;
                content.setAttribute('data-value',data.children[0][dendrogramUS.value]);
            }else {
                data.children.forEach(function (d) {
                    var index = dendrogramUS.default.indexOf(d['id']);
                    if(index !== -1){
                        content.innerHTML = '<span>'+d[dendrogramUS.label]+'</span>'+tag;
                        content.setAttribute('data-value',d[dendrogramUS.value]);
                        dendrogramUS.default.splice(index,1);
                    }
                })
            }
            box.appendChild(content);

            var dropDownDom = document.createElement('div');
            dropDownDom.className = "dendrogram-select-dropdown";
            dropDownDom.appendChild(ulDom);

            box.addEventListener("click",function () {
                dropDownDom.style.setProperty('display','block');
            });

            box.addEventListener('mouseleave',function () {
                dropDownDom.style.setProperty('display','none');
            });
            box.appendChild(dropDownDom);
            dom.appendChild(box);
            if(data.children[0].children.length > 0){
                dendrogramUS.create(data.children[0])
            }
        },
        makeDropDown:function (data) {
            if(data.length <= 0){
                return false;
            }
            var ulDom = document.createElement('ul');
            data.forEach(function (child) {
                var liDom = document.createElement('li');
                liDom.innerText = child[dendrogramUS.label];
                liDom.setAttribute('data-option',child[dendrogramUS.value]);
                if(child.children.length <= 0){
                    liDom.addEventListener('click',function () {
                        bindEvent(this);
                        dendrogramUS.callback();
                    });
                }else {
                    liDom.addEventListener('click',function () {
                        bindEvent(this);
                        dendrogramUS.create(child);
                        dendrogramUS.callback();
                    });
                }

                var bindEvent = function(that){
                    var option = that.getAttribute('data-option');
                    var box = liDom.parentNode.parentNode.parentNode.firstChild;
                    box.firstChild.textContent = child[dendrogramUS.label];
                    box.valueOf().setAttribute('data-value',option);
                    do {
                        var sub = box.parentNode.nextSibling;
                        if(!sub){
                            break;
                        }
                        var nextSub = sub.nextSibling;
                        box.parentNode.parentNode.removeChild(box.parentNode.nextSibling);
                    }while (nextSub);
                };
                ulDom.appendChild(liDom)
            });
            return ulDom;
        }
    };
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(dendrogramUS);
    } else {
        window.dendrogramUS = dendrogramUS;
    }
})(window);
