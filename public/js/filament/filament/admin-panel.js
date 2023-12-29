

// document.onkeydown = function(evt) {
//     evt = evt || window.e;
//
//     console.log(evt.target.value);
//
//     // if (e.target.value.length) {
//     //
//     // }
//     cancelKeypress = /^(8|46)$/.test("" + evt.keyCode);
//     if (cancelKeypress) {
//         return false;
//     }
// };



// document.addEventListener("keydown", function(evt) {
//     // These days, you might want to use evt.key instead of keyCode
//     if (/^(8|46)$/.test("" + evt.keyCode)) {
//         evt.preventDefault();
//     }
// }, false);


// $(function(){
//     /*
//      * this swallows backspace keys on any non-input element.
//      * stops backspace -> back
//      */
//     var rx = /INPUT|SELECT|TEXTAREA/i;
//
//     $(document).bind("keydown keypress", function(e){
//         alert('LoL');
//         if( e.which == 8 ){ // 8 == backspace
//             if(!rx.test(e.target.tagName) || e.target.disabled || e.target.readOnly ){
//                 e.preventDefault();
//             }
//         }
//     });
// });


// function test(oEvent) {
//     var key = event.which || event.keyCode || event.charCode;
//     if (key == 8 || key == 46)
//     {
//         disable; //or write  event.preventDefault(); // prevent default behavior of backspace& delete keys
//     }
// }



// document.querySelector("select").addEventListener("change", myFunction);
// // document.getElementById("fname").addEventListener("change", myFunction);
// function myFunction() {
//     alert('LoL');
//     var x = document.querySelector("select");
//     x.value = x.value.toUpperCase();
// }











//
//
//
//
// document.addEventListener("keydown", e => this.keyDownHandler(e), false);
// // document.addEventListener("keyup", e => this.keyUpHandler(e), false);
//
// function keyDownHandler(e) {
//     // console.log('value:' + e.target.value)
//
//     e.stopPropagation();
//
//     if (e.key === 'Backspace' || e.key === 'Delete')
//     {
//         // console.log(e.key);
//
//
//
//         // if (e.target.value.length) {
//             console.log('e.target.value');
//             e.stopImmediatePropagation();
//             e.preventDefault();
//
//             // e.target.keydown.reverse();
//
//         // } else {
//         //     console.log('LoL');
//         //
//         // }
//
//
//         // e.preventDefault();
//
//
//         // disable; //or write  event.preventDefault(); // prevent default behavior of backspace& delete keys
//     }
//
// }


















// function keyUpHandler(e) {
//     // console.log('value:' + e.target.value)
//     e.preventDefault();
//
//
//     if ((e.key === 'Backspace' || e.key === 'Delete') && !e.target.value)
//     {
//         console.log(e.key);
//
//         e.preventDefault();
//         // disable; //or write  event.preventDefault(); // prevent default behavior of backspace& delete keys
//     }
//
// }

// function keyUpHandler(e) {
//     console.log(e.key)
//
//     //     if (key == 8 || key == 46)
// //     {
// //         disable; //or write  event.preventDefault(); // prevent default behavior of backspace& delete keys
// //     }
//
//
// }


// document.addEventListener('alpine:init', () => {
//     console.log('bbbbbbbbbbb');
//
//     Alpine.data('cb', () => ({
//         keys: [],
//         inputLength: 4,
//         index: 0,
//
//         // init() {
//         //     // console.log('teeeeest');
//         //
//         //     this.keys = Array(this.inputLength)
//         // },
//
//         init: function() {
//             console.log('START');
//             document.addEventListener("keydown", e => this.keyDownHandler(e), false);
//             document.addEventListener("keyup", e => this.keyUpHandler(e), false);
//         },
//
//         keyDownHandler(e) {
//             console.log(e.key)
//         },
//
//         keyUpHandler(e) {
//             console.log(e.key)
//         },
//
//         clickCapture(e) {
//             if (e.key >= 0) {
//                 console.log('aaaaaaaaa');
//             }
//
//             // if (e.key >= 0 && e.key <= 9 && this.index < this.inputLength) {
//             //     this.keys[this.index] = e.key;
//             //     this.index++;
//             // }
//             if (e.key >= 0 && e.key <= 9 && this.index < this.inputLength) {
//                 console.log('asdfsadfsadfsad');
//             }
//         }
//     }))
// })















