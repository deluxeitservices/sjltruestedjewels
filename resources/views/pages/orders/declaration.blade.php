<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Compulsory Buying Form</title>

  {{-- Bootstrap (CDN) --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    body { font-family: Arial, sans-serif; background-color: #f8f9fa; padding: 20px; }
    .form-container {
      background-color: #fff; padding: 30px; border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,.2); width: 650px; margin: 0 auto; overflow: hidden;
    }
    .form-header { text-align: center; margin-bottom: 20px; }
    .form-header h1 { font-size: 2rem; margin-bottom: 0; color: #000; }
    .form-header h1 span { color: #d4af37; }
    .form-description { text-align: center; margin-bottom: 20px; font-weight: bold; font-size: 1.2rem; }
    .form-subtext { text-align: center; margin-bottom: 20px; color: #6c757d; }
    .form-group label { font-weight: bold; }
    .signature-container { text-align: center; margin-top: 20px; margin-bottom: 20px; }
    .signature-pad {
      border: 1px solid #ccc; padding: 10px; border-radius: 5px;
      background-color: #f8f9fa; text-align: left; width: 100%; height: 150px; box-sizing: border-box;
    }
    .clear-btn { display: block; margin: 10px auto; color: #007bff; cursor: pointer; border: none; background: none; padding: 0; }
    .submit-btn { text-align: center; }
    .upload-box {
      border: 2px dashed #d3d3d3; border-radius: 8px; padding: 15px; margin-bottom: 10px; background-color: #f9f9f9;
      position: relative; cursor: pointer; text-align: center;
    }
    .upload-box input[type="file"] { position: absolute; opacity: 0; width: 100%; height: 100%; top: 0; left: 0; cursor: pointer; }
    .upload-box .upload-icon { font-size: 50px; color: #7a7a7a; }
    .upload-box p { color: #666; font-size: 16px; margin: 10px 0; }
    .file-info { font-size: 14px; color: #666; margin-top: 10px; text-align: left; }
    .file-info .file-count { font-weight: bold; margin-bottom: 5px; }
    .file-info ul { padding-left: 20px; }
    .file-info li { list-style-type: disc; margin-bottom: 3px; }
    .error-message { color: red; font-size: 14px; display: none; }

    @media (max-width: 767px) {
      .form-container { padding: 15px; width: 95%; }
      .form-header h1 { font-size: 1.5rem; }
      .form-description, .form-subtext { font-size: .9rem; }
      .form-group { margin-bottom: 10px; }
      .signature-pad { height: 100px; }
      .upload-box .upload-icon { font-size: 40px; }
    }
  </style>

  {{-- jQuery + Inputmask --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
</head>
<body>

  <div class="form-container">
    <div class="form-header">
      {{-- You can swap the title if you want to show brand here --}}
      <h1>Compulsory <span>Buying Form</span></h1>
    </div>

    <div class="form-description">Compulsory Buying Form</div>

    <div class="form-subtext">
      All sections must be filled below. Your payment will only be processed when all these are filled.
    </div>

    <p>Please provide all the required details below in order for us to set up your funds. Once received, we aim to transfer your funds within 24–48 hours (online sale only) or by 8 pm the same day, whichever comes later.</p>

    <p>By signing this form you agree and certify the goods you are selling are your own property and you have the right to sell them as the lawful owner of the goods listed below.</p>

    <p>Once this form is submitted, you will have no right to claim your item back and you agree to receive the stated funds for this sale.</p>

    <p>Please note that once submitted, your payment will be set up within 24 hours on weekdays only.</p>

    {{-- FORM --}}
    <form id="compulsoryBuyingForm"
          action="{{ route('orders.declaration.submit', $order) }}"
          method="post"
          enctype="multipart/form-data"
          onsubmit="return validateForm()">
      @csrf

      {{-- Date (read-only) --}}
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date"
               name="date"
               class="form-control"
               id="date"
               value="{{ old('date', now()->format('Y-m-d')) }}"
               readonly>
      </div>

      {{-- Funds agreed --}}
      <div class="form-group">
        <label for="funds">Funds Agreed For Sale *</label>
        <input type="text"
               name="fund_agreed"
               class="form-control"
               id="funds"
               value="{{ old('fund_agreed', $order->total_gbp ?? '') }}"
               {{ isset($order->total_gbp) ? 'readonly' : '' }}>
        <div class="error-message" id="fundsError">This field is required</div>
      </div>

      {{-- Full legal name --}}
      <div class="form-group">
        <label for="fullName">Your FULL LEGAL NAME *</label>
        <div class="row">
          <div class="col-md-6">
            <input type="text"
                   class="form-control"
                   id="firstName"
                   placeholder="First Name"
                   name="firstName"
                   value="{{ old('firstName', $order->customer_name ? explode(' ', $order->customer_name)[0] : '') }}">
            <div class="error-message" id="firstNameError">This field is required</div>
          </div>
          <div class="col-md-6">
            <input type="text"
                   class="form-control"
                   name="lastName"
                   id="lastName"
                   placeholder="Last Name"
                   value="{{ old('lastName', $order->customer_name ? trim(collect(explode(' ', $order->customer_name))->slice(1)->implode(' ')) : '') }}">
            <div class="error-message" id="lastNameError">This field is required</div>
          </div>
        </div>
      </div>

      {{-- Email --}}
      <div class="form-group">
        <label for="email">Email *</label>
        <input type="email"
               class="form-control"
               name="email"
               id="email"
               value="{{ old('email', $order->customer_email) }}">
        <div class="error-message" id="emailError">This field is required</div>
      </div>

      {{-- Uploads --}}
      <div class="form-group">
        <label for="fileUpload">Please Upload Your Photo ID (Driving License or Valid Passport) *</label>
        <div class="upload-box">
          <div class="upload-icon">📤</div>
          <input type="file" name="compulsory_buying_form_image[]" id="compulsory_buying_form_image" multiple>
          <p><strong>Browse Files</strong></p>
          <p>Drag and drop files here</p>
        </div>
        <div class="file-info" id="file-info">
          <div class="file-count">No files selected</div>
          <ul id="file-list"></ul>
        </div>
        <div class="error-message" id="fileError">This field is required</div>
      </div>

      {{-- Signature --}}
      <div class="form-group signature-container">
        <label for="signature">Please E-sign This Document *</label>
        <div class="signature-pad" id="signaturePad">
          <canvas id="signatureCanvas" name="signature" width="540" height="150"></canvas>
        </div>
        <div class="error-message" id="signatureError">Please sign the document</div>
        <button type="button" class="clear-btn" id="clearButton">Clear</button>
      </div>

      {{-- Hidden fields --}}
      <div class="submit-btn">
        <input type="hidden" name="signature" id="signatureData">
        {{-- If you still need these, pass from controller and prefill here --}}
        <input type="hidden" name="formType" id="formType" value="{{ old('formType') }}">
        <input type="hidden" name="section_id" id="section_id" value="{{ old('section_id') }}">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </form>
  </div>

  {{-- JS --}}
  <script>
    $(function(){
      // Input mask for account number / sort code
      $('#accountNumber').inputmask({
        mask: "(99999999) - (99-99-99)",
        placeholder: " ",
        showMaskOnHover: false,
        showMaskOnFocus: false,
        autoUnmask: true,
        onincomplete: function() {
          alert('Please complete the account number and sort code in the correct format.');
        }
      });

      // File list display
      $('#compulsory_buying_form_image').on('change', function(e){
        const files = e.target.files || [];
        const count = files.length;
        $('#file-list').empty();
        if (count === 0) {
          $('.file-count').text("No files selected");
        } else {
          $('.file-count').text(count === 1 ? "1 file selected:" : count + " files selected:");
          for (let i=0; i<count; i++){
            $('#file-list').append($('<li>').text(files[i].name));
          }
        }
      });

      // Live hide/show error messages on change
      $('input, select, textarea').on('input change', function() {
        const id = $(this).attr('id');
        if (!id) return;
        const errId = '#' + id + 'Error';
        if ($(this).val() === '') { $(errId).show(); } else { $(errId).hide(); }
      });
    });

    // Signature Pad
    const canvas = document.getElementById('signatureCanvas');
    const signaturePad = new SignaturePad(canvas);
    document.getElementById('clearButton').addEventListener('click', function () {
      signaturePad.clear();
    });

    // Final client-side validation
    function validateForm() {
      let isValid = true;

      // Funds
      if ($('#funds').val() === '') { $('#fundsError').show(); isValid = false; } else { $('#fundsError').hide(); }
      // Names
      if ($('#firstName').val() === '') { $('#firstNameError').show(); isValid = false; } else { $('#firstNameError').hide(); }
      if ($('#lastName').val()  === '') { $('#lastNameError').show();  isValid = false; } else { $('#lastNameError').hide();  }
      // Email
      if ($('#email').val()     === '') { $('#emailError').show();     isValid = false; } else { $('#emailError').hide();     }
      // Bank fields
      if ($('#bankName').val()  === '') { $('#bankNameError').show();  isValid = false; } else { $('#bankNameError').hide();  }
      if ($('#accountNumber').val() === '') { $('#accountNumberError').show(); isValid = false; } else { $('#accountNumberError').hide(); }
      if ($('#bank').val()      === '') { $('#bankError').show();      isValid = false; } else { $('#bankError').hide();      }
      // Files
      if (!$('#compulsory_buying_form_image').val()) { $('#fileError').show(); isValid = false; } else { $('#fileError').hide(); }

      // Signature
      if (signaturePad.isEmpty()) {
        $('#signatureError').show();
        isValid = false;
      } else {
        const signatureData = signaturePad.toDataURL('image/png');
        $('#signatureData').val(signatureData);
        $('#signatureError').hide();
      }

      return isValid;
    }
    window.validateForm = validateForm;
  </script>

  {{-- SignaturePad --}}
  <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
</body>
</html>
