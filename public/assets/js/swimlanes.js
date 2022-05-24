var drag = function(event) {
    event.dataTransfer.setData("text/plain", event.target.id);
}

var allowDrop = function(ev) {
    ev.preventDefault();
    if (hasClass(ev.target,"dropzone")) {
        addClass(ev.target,"droppable bg-success");
    }
}

var clearDrop = function(ev) {
    removeClass(ev.target,"droppable bg-success");
}

var drop = function(event){



    event.preventDefault();
    var data = event.dataTransfer.getData("text/plain");
    var element = document.querySelector(`#${data}`);
    try {
        // delete the spacer in dropzone
        event.target.removeChild(event.target.firstChild);
        // add the draggable content
        event.target.appendChild(element);
        // remove the dropzone parent
        unwrap(event.target);
    } catch (error) {
        console.warn("can't move the item to the same place")
    }
    updateDropzones();


}

var updateDropzones = function(){
    /* after dropping, refresh the drop target areas
      so there is a dropzone after each item
      using jQuery here for simplicity */

    var dz = $('<div class="dropzone rounded" ondrop="drop(event);updateInputStatusDrop(this);iterateSwimlanes();" ondragover="allowDrop(event)" ondragleave="clearDrop(event)"> &nbsp; </div>');

    // delete old dropzones
    $('.dropzone').remove();

    // insert new dropdzone after each item
    dz.insertAfter('.card.draggable');

    // insert new dropzone in any empty swimlanes
    $(".items:not(:has(.card.draggable))").append(dz);
};

// helpers
function hasClass(target, className) {
    return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
}

function addClass(ele,cls) {
    if (!hasClass(ele,cls)) ele.className += " "+cls;
}

function removeClass(ele,cls) {
    if (hasClass(ele,cls)) {
        var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
        ele.className=ele.className.replace(reg,' ');
    }
}

function unwrap(node) {
    node.replaceWith(...node.childNodes);
}


function updateInputStatusDrag(element) {
    // console.log(element);

    // find out to which lane the item been dropped
    // get status value and update hiddens input value
    var swimlaneStatusValueFrom = $(element).closest("[data-status-value]").attr('data-status-value');
    var swimlaneStatusValueFrom = $(element).closest("[data-status-value]").attr('data-status-value');

    // var swimlaneStatusValue = $(element).children('.card').attr('data-status-value');


    // var swimlaneStatusValue = element.parent().getAttribute('data-id');


// console.log(swimlaneStatusValueFrom);

}

function updateInputStatusDrop(element) {
    // console.log(element.getAttribute('class'));
    // var data = element.dataTransfer.getData();
    // find out to which lane the item been dropp6ed
    // get status value and update hiddens input value
    var swimlaneStatusValueFrom = $(element).closest("[data-status-value]").attr('data-status-value');
    var swimlaneStatusValueFroms = $(element).closest("[data-id]").attr('data-id');

    console.log(swimlaneStatusValueFrom);
    console.log(swimlaneStatusValueFroms);

    // let listItemIndex = element.originalEvent;

    // var swimlaneStatusValueFrom = $(element).parent("[data-status-value]").attr('data-status-value');

    // var swimlaneStatusValue = $(element).children('.card').attr('data-status-value');


    // var swimlaneStatusValue = element.parent().getAttribute('data-id');

// console.log(listItemIndex);
// console.log($(this));
// console.log(swimlaneStatusValueFrom);
// console.log(data);

}


document.addEventListener("dragend", function(event) {
    iterateSwimlanes();
    // console.log(event);
    // console.log(event.dataTransfer);
    // document.getElementById("demo").innerHTML = "Finished dragging the p element.";
    // event.target.style.opacity = "1";
});

// odnalezc metode dzieki ktorej przy dragu znajdujemy kolumne z ktorej wychodzi zadanie i zastosowac ja do tego zeby odnalezc kolumne w ktorej robimy drop

function iterateItems() {
    $( ".card-item" ).each(function( index ) {
        let ajdi = $( this ).attr('data-id');
        let statusValue = $( this ).closest('.card-swimlane').attr('data-status-value');
        var statusInput = $(this).find('.card-item-status');
        statusInput.val(statusValue);

        console.log( "Item: [" + ajdi + "] [" + statusValue + "]  ::::" + statusInput );
    });
}

function iterateSwimlanes() {
    iterateItems();
}

function updateServer(element) {

    var swimlaneStatusValueFrom = $(element).closest("[data-status-value]").attr('data-status-value');
    var swimlaneStatusValue = $(element).closest("[data-id]").attr('data-id');

    console.log(swimlaneStatusValueFrom + " : " + swimlaneStatusValue);
}