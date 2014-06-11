$(function() {
  $('#starHalf').raty({
   click: function(score, evt) {
    console.log('ID: ' + $(this).attr('id') + "\nscore: " + score + "\nevent: " + evt.type);
    },
    path     : null,
    starOff  : 'raty-master/lib/images/star-off.png',
    starOn   : 'raty-master/lib/images/star-on.png'
  });
});