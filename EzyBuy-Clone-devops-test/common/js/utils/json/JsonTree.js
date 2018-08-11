var DebuggableObject = function(obj) {
  this.obj = obj;
};

(function() {

function isArray(a) {
  return typeof(a) == 'object' && a != undefined && a.constructor == Array;
}

function isSerializable(a) {
  var t = typeof(a);
  return t == 'string' || t == 'number' || t == 'boolean' || t == 'object' || t == 'function';
}

function isPrintable(a) {
  var t = typeof(a);
  return t == 'string' || t == 'number' || t == 'boolean' || a instanceof Date;
}

function isFunction(a) {
  return typeof(a)=='function';
}

function renderObject(obj, element) {
  if (isPrintable(obj)) {
    element.appendChild(document.createTextNode(obj));
    return;
  } else {
    var block = document.createElement('div');
    var label = isFunction(obj) ? '(function)' :
                isArray(obj)    ? '(array)'    : '(object)';
    element.appendChild(createToggleElement(obj, block, label));
  }
}

function renderObjectDetails(obj, element) {
  if (isArray(obj)) {
    var arrtab = document.createElement('table');
    arrtab.className = 'dbg-arr';
    var arrtbody = document.createElement('tbody');
    var cnt=0;
    for (var i=0; i<obj.length; i++) {
      if (isSerializable(obj[i])) {
        var row = document.createElement('tr');
        var labelCol = document.createElement('td');
        labelCol.className = 'dbg-label';
        var idx = '['+(cnt++)+']';
        labelCol.appendChild(document.createTextNode(idx));
        var valueCol = document.createElement('td');
        valueCol.className = 'dbg-value';
        renderObject(obj[i], valueCol);
        row.appendChild(labelCol);
        row.appendChild(valueCol);
        arrtbody.appendChild(row);
      }
    }
    arrtab.appendChild(arrtbody);
    element.appendChild(arrtab);

  } else if (isFunction(obj)) {
    element.appendChild(document.createTextNode(obj));

  } else {
    var objtab = document.createElement('table');
    objtab.className = 'dbg-obj';
    var objtbody = document.createElement('tbody');
    for (var propName in obj) {
      if (isSerializable(obj[propName])) {
        var row = document.createElement('tr');
        var labelCol = document.createElement('td');
        labelCol.className = 'dbg-label';
        labelCol.appendChild(document.createTextNode(propName));
        var valueCol = document.createElement('td');
        valueCol.className = 'dbg-value';
        renderObject(obj[propName], valueCol);

        row.appendChild(labelCol);
        row.appendChild(valueCol);
        objtbody.appendChild(row);
      }
    }
    objtab.appendChild(objtbody);
    element.appendChild(objtab);
  }
}


function createToggleElement(obj, target, label) {
  target.style.display = 'none';
  var toggle = document.createElement('div');
  toggle.appendChild(document.createTextNode(label));
  toggle.className = 'dbg-toggle';
  var wrapper = document.createElement('div');
  wrapper.className = 'dbg-toggle-closed';
  toggle.onclick = function() {
    if (wrapper.className=='dbg-toggle-closed') {
      wrapper.className = 'dbg-toggle-open';
      if (!target.firstChild) {
        renderObjectDetails(obj, target);
      }
      target.style.display = 'block';
    } else {
      wrapper.className = 'dbg-toggle-closed';
      target.style.display = 'none';
    }
  }
  toggle.onclick();
  wrapper.appendChild(toggle);
  wrapper.appendChild(target);
  return wrapper;
}

function toJSON(obj) {
  if (isPrintable(obj)) {
    return '"' + obj.toString()
                    .replace(/(\\|\")/g, '\\$1')
                    .replace(/\n|\r|\t/g, function(a){
                       return (a=='\n') ? '\\n':
                              (a=='\r') ? '\\r':
                              (a=='\t') ? '\\t': ''
                    }) + '"';

  } if (isArray(obj)) {
    var out = [];
    for (var i=0; i<obj.length; i++) {
      if (isSerializable(obj[i]) && !isFunction(obj[i])) {
        out.push(toJSON(obj[i]));
      }
    }
    return '['+out.join(',')+']';

  } else {
    var out = [];
    for (var propName in obj) {
      if (isSerializable(obj[propName]) && !isFunction(obj[propName])) {
        out.push('"'+propName+'":'+toJSON(obj[propName]));
      }
    }
    return '{'+out.join(',')+'}';
  }
}

DebuggableObject.prototype = {

  render : function (element) {
    while (element.firstChild) element.removeChild(element.firstChild);
    var cell = document.createElement('div');
    cell.className = 'dbg-value';
    renderObject(this.obj, cell);
    element.appendChild(cell);
  }
  ,
  toString : function () {
    return toJSON(this.obj);
  }
}

})();