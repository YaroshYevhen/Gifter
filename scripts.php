<script src="public/modernizr-custom.js"></script>
<script src="public/vendor.js"></script>
<script src="public/bundle.js"></script>
<script src="public/card.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/card/2.5.0/card.min.js"></script>
<script>
    $(document).ready(function() {
        $('#registration').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                }
            },
            messages: {
                email: {
                    required: "Please enter email",
                    email: "Неверно введена почта. Попробуйте еще раз."
                },
                password: {
                    required: "Please enter password",
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
      $('#main-page-form2').hide();
      $('#main-page-form1 button').click((e) => {
        e.preventDefault();
        $('#main-page-form1').hide();
        $('#main-page-form2').show();
      })
      $('#card-number').inputmask({"mask": "9999 9999 9999 9999"});
      $('#card-expiry').inputmask({"mask": "99/99"});
      $('#card-cvc').inputmask({"mask": "999"});
      new Card({
        form: document.querySelector('#form'),
        container: '.card-wrapper',
        formatting: true,
      });
    });
</script>

