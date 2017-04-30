$(document).ready(function() {
    $('#form').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        //group: '.form-group',
        fields: {
            image_file: {
                validators: {
                    file: {
                        extension: 'jpg',
                        type: 'image/jpeg',
                        maxSize: 5*1024*1024,
                        message: 'Please choose a jpg file with a size less than 5M.'
                    }
                }
            },
            location: {
                validators: {
                    notEmpty: {
                        message: 'Location is required'
                    }
                }
            }
        }
    });
});

$(function(){
    $('#datetimePicker').datetimepicker();
});

function ukey() {
  function x4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }
  return x4() + x4() + '-' + x4() + '-' + x4() + '-' +
    x4() + '-' + x4() + x4() + x4();
}

document.getElementById('ukey').value = ukey();
document.getElementById('token').value = ukey();

d = new Date();
$('#dateField').val(d.toLocaleString());