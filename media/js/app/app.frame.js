class App extends amazonia.frame {
    constructor () {
        super();
    }
}

amazonia.apps["super"] = new App();
amazonia.apps["super"].encender();

{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
        this.hasToRun = false;
    }

    $render() {
        let $ctrl = this;
        let captured = $ctrl.value;
        let funct = function () {
            return eval (captured);
        }
        console.log ($ctrl.$scope);
        let data = funct.call ($ctrl.$scope);
        if (!data) {
            console.log ("false");
            this.app.convertNodeToNone (this.nodeElement);
        } else {
            this.app.evaluated = false;
        }
        
    }
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-if",
    create: Attribute
});
}


{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
        this.repeated = [];
    }

    controller () {
        let $ctrl = this;
        this.$init = function () {
        }

        this.$render = function () {
            
            let $ctrl = this;
            if (!this.nodeElement.repeatData) {
                this.cloned = this.app.cloneNodeElement (this.nodeElement, true);
                this.nodeElement.first = true;
                this.repeated = [this.nodeElement];
            }
            
            if (this.nodeElement.first) {
                let exp = /^let ([a-z|A-Z_]+[a-zA-Z\d_]*) in ([a-z|A-Z_]+\w*[.?\w\[\]]*)$/;
            
                let captured = exp.exec ($ctrl.value);
                if (!captured || captured.length <= 0) {
                    throw "Error: The am-repeat attribute doesn't have a well formatted text";
                }
                
                let funct = function () {
                    return eval (captured[2]);
                };

                let data = funct.call(this.$scope);
                
                this.nodeElement.repeatData = data;
                
                if (this.nodeElement.repeatData.length > 0) {
                    this.nodeElement.repeatContent = this.nodeElement.repeatData[0];
                }
                
                let count = 0;
                for (let i in this.nodeElement.repeatData) {
                    if (!this.repeated[i]) {
                        let clone = this.app.cloneNodeElement (this.cloned, true);
                        console.log (clone);
                        this.app.appendNodeElement (this.nodeElement.parent, clone);
                        this.repeated[i] = clone;
                        console.log (this.repeated[i]);
                    }

                    this.repeated[i].repeatRenderizable = captured[1];
                    this.repeated[i].repeatData = this.nodeElement.repeatData;
                    this.repeated[i].repeatContent = this.nodeElement.repeatData[i];
                    this.repeated[i].repeatIndex = i;

                    count++;
                }

                console.log (count, this.repeated);
                
                if (count < this.repeated.length) {
                    for (let i = count; i < this.repeated.length; i++) {
                        if (this.repeated[i].first) {
                            this.app.convertNodeToNone (this.repeated[i]);
                        } else {
                            this.app.removeNodeElement (this.repeated[i].parent, this.repeated[i]);
                            if (this.repeated[i].element.parentNode) {
                                this.repeated[i].element.parentNode.removeChild (this.repeated[i].element);
                            }
                            
                        }
                    }
                    
                }
            }
            
            this.$scope[this.nodeElement.repeatRenderizable] = this.nodeElement.repeatContent;
            this.$scope.$index = this.nodeElement.repeatIndex;
        }
    }
    /*
    refact (element, clone) {
        if (element instanceof Text) {
            element.data = clone.data;
        } else {
            for (var j = 0; j < clone.attributes.length; j++) {
                if (clone.attributes.item(j).nodeName != 'data-am-id') {
                    element.removeAttribute (clone.attributes.item(j).nodeName);
                    element.setAttribute (clone.attributes.item(j).nodeName, clone.attributes.item(j).nodeValue);
                }
            }
            for (let i = 0; i < clone.childNodes.length; i++) {
                this.refact (element.childNodes[i], clone.childNodes[i]);
            }
        }
        
    }*/
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-repeat",
    create: Attribute
});
}
/*{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
    }

    $render () {
        let $ctrl = this;
        let captured = 'capturedText = ' + $ctrl.value;
        let funct = function () {
            let capturedText;
            eval (captured);
            return capturedText;
        };

        let data = funct.call(this.$scope);

        this.element.checked = !!data;
        
        
    }
}

amazonia.apps["super"].atributos.push({
    nombre: "am-checked",
    create: Attribute
});
}
{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
    }

    $render () {
        let $ctrl = this;
        let captured = 'capturedText = ' + $ctrl.value;
        let funct = function () {
            let capturedText;
            eval (captured);
            return capturedText;
        };

        let data = funct.call(this.$scope);

        
        if (data) {
            this.element.selected = true;
            
        }
            
        
    }
}

amazonia.apps["super"].atributos.push({
    nombre: "am-selected",
    create: Attribute
});
}

{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
        this.hasToRun = false;
    }

    controller () {
        let $ctrl = this;
        $ctrl.$init = function () {

            $ctrl.element.addEventListener ('click', function () {
                $ctrl.hasToRun = true;
                setTimeout (() => {$ctrl.app.aplicar();$ctrl.app.aplicar();}, 0);
                
            });
        }
        
    }

    $render() {
        if (this.hasToRun) {
            let $ctrl = this;
            let captured = $ctrl.value;
            let funct = function () {
                eval (captured);
            };
            funct.call($ctrl.$scope);
            this.hasToRun = false;
        }
        
    }
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-click",
    create: Attribute
});
}

{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
        this.hasToRun = false;
    }

    controller () {
        let $ctrl = this;
        $ctrl.$init = function () {
            $ctrl.app.captureWatch ($ctrl);
        }
        $ctrl.$render = function () {
            $ctrl.element.value = $ctrl.getValue();
        }
    }
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-value",
    create: Attribute
});
}
*/
{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
        this.hasToRun = false;
    }

    controller () {
        let $ctrl = this;
        $ctrl.$init = function () {
            let $ctrl = this;
            $ctrl.element.addEventListener ('submit', function (evt) {
                evt.preventDefault();
                
                let captured = $ctrl.value;
                let funct = function () {
                    eval (captured);
                };
                funct.call($ctrl.$scope);
                
                setTimeout (() => {$ctrl.app.aplicar();}, 0);
            });
        }
        
    }

    $render() {
        
    }
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-submit",
    create: Attribute
});
}
/*

{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
    }

    controller () {
        let $ctrl = this;
        
        this.$render = function () {
            let captured = 'capturedText = ' + $ctrl.value;
            let funct = function () {
                let capturedText;
                eval (captured);
                return capturedText;
            };

            let data = funct.call(this.$scope);
            for (let i in data) {
                if (data[i]) {
                    this.element.classList.add(i);
                } else {
                    this.element.classList.remove(i);
                }
            }
        }
    }
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-class",
    create: Attribute
});
}
*/
{
class Attribute extends amazonia.atributo {
    constructor () {
        super();
    }

    controller () {
        let $ctrl = this;
        let lastPrinted;

        $ctrl.$init = function () {
            $ctrl.app.captureWatch ($ctrl);

            if ($ctrl.element.nodeName == 'INPUT') {
                if ($ctrl.element.getAttribute ('type') == 'text'
                    || $ctrl.element.getAttribute ('type') == 'password'
                    || $ctrl.element.getAttribute ('type') == 'hidden') {
                    $ctrl.element.addEventListener ('input', function () {
                        $ctrl.asignValue ($ctrl.element.value);
                        setTimeout (() => {$ctrl.app.aplicar()}, 1);
                    });
                }

                if ($ctrl.element.getAttribute ('type') == 'checkbox') {
                    $ctrl.element.addEventListener ('change', function () {
                        $ctrl.hasToRun = true;
                        setTimeout (() => {$ctrl.app.aplicar();$ctrl.app.aplicar();}, 1);
                    });
                }

                if ($ctrl.element.getAttribute ('type') == 'radio') {
                    $ctrl.element.addEventListener ('change', function() {
                        $ctrl.hasToRun = true;
                        setTimeout (() => {$ctrl.app.aplicar();$ctrl.app.aplicar();}, 1);
                    })
                }
                
            } else if ($ctrl.element.nodeName == 'TEXTAREA') {
                $ctrl.element.addEventListener ('input', function () {
                    $ctrl.asignValue($ctrl.element.value);
                    setTimeout (() => {$ctrl.app.aplicar()});
                });
            } else if ($ctrl.element.nodeName == 'SELECT') {
                $ctrl.element.addEventListener ('change', function () {
                    let value = $ctrl.element.multiple ? Array.from($ctrl.element.selectedOptions).map(v=>v.value) : $ctrl.element.value;
                    $ctrl.asignValue(value);
                    setTimeout (() => {$ctrl.app.aplicar()});
                    
                })
            }
            
        }

        $ctrl.$render = function () {
            let curr = $ctrl.getValue();
            let haveToChange = lastPrinted !== curr;
            lastPrinted = curr;
            
            
            switch ($ctrl.element.nodeName) {
                case 'INPUT':
                    if ($ctrl.element.getAttribute ('type') == 'text'
                        || $ctrl.element.getAttribute ('type') == 'password'
                        || $ctrl.element.getAttribute ('type') == 'hidden') {
                        if ($ctrl.element.value !== curr) {
                            $ctrl.element.value = curr;
                        }
                        
                    }
                        
                    if ($ctrl.element.getAttribute ('type') == 'checkbox') {
                        if ($ctrl.hasToRun) {
                            $ctrl.asignValue($ctrl.element.checked);
                            $ctrl.hasToRun = false;
                        }
                        if ($ctrl.element.checked != curr) {
                            $ctrl.element.checked = curr;
                        }
                    }

                    if ($ctrl.element.getAttribute ('type') == 'radio') {
                        if ($ctrl.hasToRun) {
                            $ctrl.asignValue ($ctrl.element.value);
                            $ctrl.hasToRun = false;
                        }
                        if ($ctrl.element.checked != ($ctrl.element.value == curr)) {
                            $ctrl.element.checked = $ctrl.element.value == curr;
                        }
                        
                    }
                    break;
                case 'TEXTAREA':
                    if ($ctrl.element.value !== curr) {
                        $ctrl.element.value = curr;
                    }
                        
                    
                    break;
                case 'SELECT':
                    if ($ctrl.element.multiple) {
                        let vals = $ctrl.getValue();
                        for (let i = 0; i < $ctrl.element.options.length; i++) {
                            let e = $ctrl.element.options[i];
                            if (e.selected != vals.indexOf (e.value) >= 0) {
                                e.selected = vals.indexOf (e.value) >= 0;
                            }
                        }
                    } else {
                        if ($ctrl.element.value != curr) {
                            $ctrl.element.value = curr;
                        }
                    }
                    break;
            }
        }
    }
    
}

amazonia.apps["super"].atributos.push({
    nombre: "am-model",
    create: Attribute
});
}
