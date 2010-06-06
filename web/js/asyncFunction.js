/** 
 * Quick function for asnycronously loaded code that indicates it is loaded 
 * by calling a global function I.E Facebook connect js
 * 
 * Usage:
 * Set the global var
 * var fbAsyncInit = new AsyncFunction(function() { console.log('my app is initiated'); });
 * 
 * Add methods:
 * fbAsyncInit.addMethod(function() { console.log('library is loaded') });
 */

var AsyncFunction = function (initMethod) {
    // actual function to be called
    asyncVar = function() {
        while (asyncVar.queue.length) {
          var func = asyncVar.queue.shift();
          if (typeof func == 'function') {
            func();
          }
        }
        asyncVar.loaded = true;
    }
    // whether the async code is loaded
    asyncVar.loaded = false;
    // the method queue
    asyncVar.queue = [];
    // this is where methods should be called, will be ran instantly if loaded
    // otherwise added to queue
    asyncVar.addMethod = function(func, front) {
        if (asyncVar.loaded) {
            func();
        } else if ((typeof front != 'undefined') && front) {
            // method added to front of queue
            asyncVar.queue.unshift(func);
        } else {
          asyncVar.queue.push(func);
        }
    };

    // initMethod added to front of queue
    if (typeof initMethod == 'function') {
      asyncVar.addMethod(initMethod, true);
    }

    return asyncVar;
}