$(document).ready(function () {
    $("#item-created").persianDatepicker({
        format: 'YYYY/MM/DD HH:mm',
//        initialValue: true,
//        initialValueType: 'gregorian',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });
    console.log('GFDSA');
});