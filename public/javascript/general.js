jQuery(function() {
  jQuery('#txtStartDate, #txtEndDate').datepicker();
  jQuery('#txtStartDate, #txtEndDate').datepicker('option', {
    beforeShow: customRange
  });
});


function customRange(input) {
  if (input.id == 'txtEndDate') {
    return {
      minDate: jQuery('#txtStartDate').datepicker("getDate")
    };
  } else if (input.id == 'txtStartDate') {
    return {
      maxDate: jQuery('#txtEndDate').datepicker("getDate")
    };
  }
}

$(document).ready(function() {
  $(".add-room-type-fancybox").fancybox({
    maxWidth      : 800,
    maxHeight     : 600,
    fitToView     : false,
    width         : '70%',
    height          : '70%',
    autoSize      : true,
    closeClick      : false,
    openEffect      : 'none',
    closeEffect     : 'none'
  });
  
  $(".add-facility-fancybox").fancybox({
    maxWidth      : 500,
    maxHeight     : 150,
    fitToView     : false,
    width         : '70%',
    height          : '70%',
    autoSize      : true,
    closeClick      : false,
    openEffect      : 'none',
    closeEffect     : 'none'
  });

  $(".add-city-fancybox").fancybox({
    maxWidth      : 500,
    maxHeight     : 150,
    fitToView     : false,
    width         : '70%',
    height          : '70%',
    autoSize      : true,
    closeClick      : false,
    openEffect      : 'none',
    closeEffect     : 'none'
  });
  $.post('home/cities', function(response){
      var cities=response;
      obj = JSON.parse(cities);
      var city = new Array();
      for (var i = 0; i < obj.length; i++) {
        city[i] = obj[i].city_name;
      };
      $( "#location" ).autocomplete({
      source: city
		});
    });
	
	$("#add_options").click(function () {
	$("#facilities").slideToggle("slow");
	});
	
	$("#chart_button").click(function () {
	$("#chart").slideToggle("slow");
	});
});

function showAddNewRoomType(element) {
  if( $(element).val() == 'add_room' ) {
    $('.add-room-type-fancybox').click();
  }
}

function showAddNewFacility(element) {
  if( $(element).val() == 'add_facility' ) {
    $('.add-facility-fancybox').click();
  }
}

function showAddNewCity(element) {
  if( $(element).val() == 'add_city' ) {
    $('.add-city-fancybox').click();
  }
}

function addImages(){

  var maindiv = $('.images');
  var div = $('<div></div>').attr('class', 'image');
  var label = $('<label></label>').attr('for', 'hotel_image').html('Imagine');
  var image = $("<input>", { type: "file", name: "hotel_image[]"});
  var del_image = $("<input>", { type: "button", value: "sterge"}).click( function() {
    $(this).parent().hide('slow', function(){ $(this).remove()}); });
  console.log(div);
  div.append(label);
  div.append(image);
  div.append(del_image);
  maindiv.append(div);
  
}

function add_camera(){

  var maindiv  = $('.selecteaza_camere');
  var div      = $( '<div></div>' ).attr( 'class', "camera" );
  var input1   = $("<input>", { type: "text", name: "total_camere[]"});
  var input2   = $("<input>", { type: "text", name: "pret[]"});
  var label = $('<label></label>').attr('for', 'room_image').html('Imagine');
  var image = $("<input>", { type: "file", name: "room_image[]"});
  $.ajax({
    type: "POST",
    url: '../admin/types',
    dataType: 'json',
    async:false,
    success: function (data) {
      camere = data;
    }
  }).responseText;
  var a = $("<a></a>").attr("href", "../admin/newtype?modal").attr("class", ".add-room-type-fancybox");
  var select = getSelectRooms( "tip[]", "tip[]", camere);
  console.log(select);
  var input3   = $("<input>", { type: "button", value: "sterge"}).click( function() {
    $(this).parent().hide('slow', function(){ $(this).remove()}); });
  div.append( select );
  div.append( "<br>" );
  div.append( "Numarul total de camere de acest tip: ");
  div.append( input1 );
  div.append( " Pret pe noapte: ");
  div.append( input2 );
  div.append(label);
  div.append(image);
  div.append( input3 );
  maindiv.append( div );
}

function getSelectRooms(name, id, optionList) {
  var combo = $("<select></select>").attr("id", id).attr("name", name).addClass('types').change(function() { showAddNewRoomType(this); });

  combo.append("<option value=''>Selectati tipul de camera</option>");
  combo.append("<option value='add_room' >Adauga un nou tip</option>");
  $.each(optionList, function (i, el) {
    combo.append("<option value='" + el.type_id +"' title='" + el.description + "' '>" + el.type_name + "</option>");
  });
  return combo;
}

function add_facilitate(){

  var maindiv  = $('.selecteaza_facilitati');
  var div      = $( '<div></div>' ).attr( 'class', "facilitate" );

  $.ajax({
    type: "POST",
    url: '../admin/facilities',
    dataType: 'json',
    async:false,
    success: function (data) {
      facilitati = data;
    }
  }).responseText;
  var a = $("<a></a>").attr("href", "../admin/addfacility?modal").attr("class", ".add-facility-fancybox");
  var select = getSelectFacilities( "facilitate[]", "facilitate[]", facilitati);
  console.log(select);
  var input = $("<input>", { type: "button", value: "sterge"}).click( function() {
    $(this).parent().hide('slow', function(){ $(this).remove()}); });
  div.append( select );
  div.append( input );
  maindiv.append( div );
}

function getSelectFacilities(name, id, optionList) {
  var combo = $("<select></select>").attr("id", id).attr("name", name).addClass('facilities').change(function() { showAddNewRoomType(this); });

  combo.append("<option value=''>Selectati facilitate</option>");
  combo.append("<option value='add_room' >Adauga facilitate</option>");
  $.each(optionList, function (i, el) {
    combo.append("<option value='" + el.facility_id +"''>" + el.facility_name + "</option>");
  });
  return combo;
}

function adauga_tip() {
  $.ajax({
    "url": '../admin/newtype?modal=1', 
    'accept': "text/*",
    "data" : $('#adauga_tip_camera_form').serialize(),
    'success': function(data,status){
      result = $.parseJSON(data);
      if(result.error != '' || result == null ) {
        alert(result.error);
      }
      else {
        var option = $("<option></option>", {
          "value": result.tip_id,
          "title": result.descriere,
          "text": result.nume
        });
        $('select.types').each( function(index) { 
          console.log( index) ;
          $(this).append(option);  
        });
        $.fancybox.close( true );
      }
    },
    'error': function(data){ 
      alert( "Error while adding new type" );
    }
  });
  return false;
}

function adauga_oras() {
  $.ajax({
    "url": '../admin/addcity?modal=1', 
    'accept': "text/*",
    "data" : $('#adauga_oras_form').serialize(),
    'success': function(data,status){
      result = $.parseJSON(data);
      if(result.error != '' || result == null ) {
        alert(result.error);
      }
      else {
        var option = $("<option></option>", {
          "value": result.oras_id,
          "text": result.nume
        });
        $('select.cities').each( function( index ) {
          $(this).append(option);
        }); 
        $.fancybox.close( true );
      }
    },
    'error': function(data){ 
      alert( "Error while adding new type" );
    }
  });
  return false;
}


function adauga_facilitate() {

  $.ajax({
    "url": '../admin/addfacility?modal=1', 
    'accept': "text/*",
    "data" : $('#adauga_facilitate_form').serialize(),
    'success': function(data,status){
      result = $.parseJSON(data);
      if(result.error != '' || result == null ) {
        alert(result.error);
      }
      else {
        var option = $("<option></option>", {
          "value": result.facility_id,
          "text": result.nume
        });
        $('select.facilities').each( function() { 
          $(this).append(option);  
        });
        $.fancybox.close( true );
      }
    },
    'error': function(data){ 
      alert( "Error while adding new type" );
    }
  });
  return false;
  
}


function delete_data(type, id) {
  if(confirm("Sunteti sigur ca vreti sa stergeti data?")) {
    var sendData = id;
    $('#del-'+id).hide();
    $.post('delete' + type +'/' + sendData, sendData, function(response){
      var del_id="#del_" + type + "-"+id;
      $(del_id).fadeOut('slow', function(){ $(del_id).parent().parent().remove();});
    });
  }
}


function getInterval(id){

  $.ajax({
    type: "POST",
    url: '../interval/' + id,
    dataType: 'json',
    async:false,
    success: function (data) {
      interval = data;
	  
	  showDiagram(interval);
    }
  }).responseText;

}

   var dateFormat = function () {
        var    token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
            timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
            timezoneClip = /[^-+\dA-Z]/g,
            pad = function (val, len) {
                val = String(val);
                len = len || 2;
                while (val.length < len) val = "0" + val;
                return val;
            };
    
        // Regexes and supporting functions are cached through closure
        return function (date, mask, utc) {
            var dF = dateFormat;
    
            // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
            if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
                mask = date;
                date = undefined;
            }
    
            // Passing date through Date applies Date.parse, if necessary
            date = date ? new Date(date) : new Date;
            if (isNaN(date)) throw SyntaxError("invalid date");
    
            mask = String(dF.masks[mask] || mask || dF.masks["default"]);
    
            // Allow setting the utc argument via the mask
            if (mask.slice(0, 4) == "UTC:") {
                mask = mask.slice(4);
                utc = true;
            }
    
            var    _ = utc ? "getUTC" : "get",
                d = date[_ + "Date"](),
                D = date[_ + "Day"](),
                m = date[_ + "Month"](),
                y = date[_ + "FullYear"](),
                H = date[_ + "Hours"](),
                M = date[_ + "Minutes"](),
                s = date[_ + "Seconds"](),
                L = date[_ + "Milliseconds"](),
                o = utc ? 0 : date.getTimezoneOffset(),
                flags = {
                    d:    d,
                    dd:   pad(d),
                    ddd:  dF.i18n.dayNames[D],
                    dddd: dF.i18n.dayNames[D + 7],
                    m:    m + 1,
                    mm:   pad(m + 1),
                    mmm:  dF.i18n.monthNames[m],
                    mmmm: dF.i18n.monthNames[m + 12],
                    yy:   String(y).slice(2),
                    yyyy: y,
                    h:    H % 12 || 12,
                    hh:   pad(H % 12 || 12),
                    H:    H,
                    HH:   pad(H),
                    M:    M,
                    MM:   pad(M),
                    s:    s,
                    ss:   pad(s),
                    l:    pad(L, 3),
                    L:    pad(L > 99 ? Math.round(L / 10) : L),
                    t:    H < 12 ? "a"  : "p",
                    tt:   H < 12 ? "am" : "pm",
                    T:    H < 12 ? "A"  : "P",
                    TT:   H < 12 ? "AM" : "PM",
                    Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                    o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                    S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                };
    
            return mask.replace(token, function ($0) {
                return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
            });
        };
    }();
    
    // Some common format strings
    dateFormat.masks = {
        "default":      "ddd mmm dd yyyy HH:MM:ss",
        shortDate:      "m/d/yy",
        mediumDate:     "mmm d, yyyy",
        longDate:       "mmmm d, yyyy",
        fullDate:       "dddd, mmmm d, yyyy",
        shortTime:      "h:MM TT",
        mediumTime:     "h:MM:ss TT",
        longTime:       "h:MM:ss TT Z",
        isoDate:        "yyyy-mm-dd",
        isoTime:        "HH:MM:ss",
        isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
        isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
    };
    
    // Internationalization strings
    dateFormat.i18n = {
        dayNames: [
            "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
            "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
        ],
        monthNames: [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
            "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
        ]
    };
    
    // For convenience...
    Date.prototype.format = function (mask, utc) {
        return dateFormat(this, mask, utc);
    };

function showDiagram(interval) {

	var  between = [],
	start = new Date(interval["check_in"]),
	end = new Date(interval["check_out"]),
	occupation = [];

	var reservations = interval["rezervations"];
	
	for (var i = 0; i < reservations.length; i++) {
		reservations[i]["from_date"] =  new Date(reservations[i]["from_date"]);
		reservations[i]["to_date"] =  new Date(reservations[i]["to_date"]);
	}
	
	while (start <= end) {
        between.push(new Date(start));
        start.setDate(start.getDate() + 1);
    }
	
	var len = between.length;
	for (var i = 0; i < len; i++) {
		occupation.push(0);
		for (var j = 0 ; j < reservations.length; j++) {
			if ( between[i].getTime() >= reservations[j]["from_date"].getTime() && between[i].getTime() <= reservations[j]["to_date"].getTime()) {
				occupation[i] = parseInt(occupation[i]) + parseInt(reservations[j]["number_of_rooms"]);
			}
		}	
	}
	var total = interval["count"][0]["total_rooms"];
	var dates = []; 
	for (var i = 0; i < between.length; i++) {
		between[i] = between[i].format("dd-m-yy");
		dates.push([between[i], occupation[i]]);
	}

	$('#chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Gradul de ocupare a hotelului pe periodată selectată.'
            },
            subtitle: {
                text: 'Zile'
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    align: 'right',
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Camere'
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Camere ocupate: <b>{point.y:.0f} din ' + total + ' </b>',
            },
            series: [{
                name: 'Camere',
                data: dates,
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    align: 'right',
                    x: 4,
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        textShadow: '0 0 3px black'
                    }
                }
            }]
        });

}

