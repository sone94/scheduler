 $(document).ready(function() {

  // $.ajaxSetup({
  //   headers: {
  //       'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
  //   }
  // });
  $(function () {
    $('[data-toggle="tooltip"]').tooltip({
      // container: 'body',
      // animated : 'fade',
      // placement : 'bottom',
    })
  })
   var calendar = $('#calendar').fullCalendar({
    editable:true,
    displayEventTime: false,
    eventColor:'#F95700FF',
    eventDidMount: function(info) {
      var tooltip = new Tooltip(info.el, {
        title: info.event.extendedProps.title,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    },
    header:{
     left:'prev,next today',
     center:'title',
     right:'month'
    },
    events: 'events',
    selectable:true,
    selectHelper:true,
    select: function(start, end, allDay)
    {
     var title = prompt("Enter Event Title");
     if(title)
     {
      var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
      var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
       $.ajax({
        url:"events",
        type:"POST",
        data:{
            title:title,
            start:start,
            end:end,
            "_token": $token,
          },
        success:function(data)
        {

        calendar.fullCalendar('refetchEvents');
        setResponseMessage('#successMsg', data.success);
          
        },
        error:function(data){
          setResponseMessage('#errorMsg', data.responseJSON.error);
        }
       })
     }
    },
    editable:true,
    eventResize:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = event.title;
     var id = event.id;
      $.ajax({
        url:"events/"+id+"/edit",
        type:"PUT",
        data:{title:title, start:start, end:end, id:id},
        success:function(){
        calendar.fullCalendar('refetchEvents');
        alert('Event Update');
        }
      })
    },
    eventMouseover: function(event, jsEvent, view) {
      console.log(this);
      $(this).closest('.fc-event-container').append('<button id=\"'+event.id+'\" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Tooltip on right">'+event.title+'</button>');

  },
  
  eventMouseout: function(event, jsEvent, view) {
      $('#'+event.id).remove();
  },

    eventDrop:function(event)
    {
     var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
     var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
     var title = prompt("Enter Event Title", event.title);
     var id = event.id;
      $.ajax({
        url:"events/"+id+"/edit",
        type:"PUT",
        data:{title:title, start:start, end:end, id:id},
        success:function(data)
        {
        calendar.fullCalendar('refetchEvents');
        setResponseMessage('#successMsg', data.success);
        }
      });
    },
    
    eventClick:function(event)
    {

    },
    eventReceive: function(event) {
      var newEventDay = event.start.startOf('day');
      var existingEvents = $("#calendar").fullCalendar("clientEvents", function(evt) {
        //this callback will run once for each existing event on the current calendar view
        //if the event has the same start date as the new event, include it in the returned list (to be counted)
        if (evt.start.startOf('day').isSame(newEventDay)) {
          return true;
        } else {
          return false;
        }
      });
    
      //if this new event means there are now more than 2 events on that day, remove this new event again (N.B. we must do it like this because by this point the event has already been rendered on the calendar)
      if (existingEvents.length > 1) $("#calendar").fullCalendar("removeEvents", function(evt) {
        if (evt == event) return true;
      });
    },
    eventRender: function(event, element) {
      element.find('.fc-title').prepend('<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pencil edit" fill="#FFFFFF" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/><path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/></svg>');
      element.find('.fc-content').append( "<span class='closeon'><strong>x</strong></span>");
      element.find(".closeon").click(function() {
        element.attr('checked');
        console.log(element);
        if(confirm("Are you sure you want to remove it?"))
        {
         var id = event.id;
           $.ajax({
           url:"events/"+id,
           type:"DELETE",
           data:{id:id},
           success:function(data)
           {
             calendar.fullCalendar('refetchEvents');
             setResponseMessage('#successMsg', data.success);
           }
           })
        }
      });

      element.find(".edit").click(function() {
        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
        var title = prompt("Enter Event Title", event.title);
        var id = event.id;
        if(title)
        {
          $.ajax({
            url:"events/"+id+"/edit",
            type:"PUT",
            data:{title:title, start:start, end:end, id:id},
            success:function(data){
            calendar.fullCalendar('refetchEvents');
              setResponseMessage('#successMsg', data.success);
            }
          })
        }
        

      });


  }
  
  
   });

  });
