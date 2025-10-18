<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SJL Trusted Jewels</title>
  <link href="{{ URL::asset('/css/bootstrap.min.css') }}?t=2" rel="stylesheet" />
  <link rel="stylesheet" href="{{ URL::asset('/css/owl.carousel.min.css') }}?t=2?t=2">
  <link rel="stylesheet" href="{{ URL::asset('/css/owl.theme.default.min.css') }}?t=2?t=2">
  <link rel="icon" href="{{ asset('./assets/image/favicon.ico') }}" type="image/x-icon" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/easyzoom/2.5.2/easyzoom.min.css">
  <link rel="stylesheet" href="https://icodefy.com/Tools/iZoom/js/Vendor/fancybox/helpers/jquery.fancybox-thumbs.css">
  <link rel="stylesheet" href="{{ URL::asset('/css/zoom.css') }}?t=2?t=2">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="{{ URL::asset('./css/common.css') }}?t=4" />
  <link rel="stylesheet"
    href="https://cdn.datatables.net/2.3.3/css/dataTables.dataTables.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.8/slick.min.css">
</head>

<body>
  @include('partials._header')
  @yield('content')
  @include('partials._footer')
  @stack('scripts')
</body>
<script>
  new DataTable('#order-list-table', {
    order: [[2, 'desc']],
    columnDefs: [{
      className: "dt-left",
      targets: "_all"
    }],
    scrollX: true,
    responsive: true,

  })
  new DataTable('#wishlist-table', {
    scrollX: true,
    responsive: true,
    columnDefs: [{
      className: "dt-left",
      targets: "_all"
    }],

  })

  new DataTable('#address-list-table', {
    scrollX: true,
    responsive: true,
    order: [[6, 'desc']],
    columnDefs: [{
      className: "dt-left",
      targets: "_all"
    }],

  })



</script>
@auth
<script>
document.addEventListener('click', async (e) => {
  const btn = e.target.closest('.js-fav');
  const icon = btn.querySelector('i');

  if (!btn) return;

  const body = {
    external_id: btn.dataset.externalId,
    title: btn.dataset.title || null,
    prefix: btn.dataset.prefix || null,
    slug: btn.dataset.slug || null,
    sku: btn.dataset.sku || null,
    image_url: btn.dataset.image || null,
    _token: '{{ csrf_token() }}'
  };

  try{
    const r = await fetch('{{ route('favorites.toggle') }}', {
      method: 'POST',
      headers: {'Accept':'application/json','X-Requested-With':'XMLHttpRequest'},
      body: new URLSearchParams(body)
    });
    const j = await r.json();
    if (j.status === 'added') {
      icon.classList.add('fa-solid', 'is-favorited');
      icon.classList.remove('fa-regular');
      btn.classList.add('is-favorited');
      
    } else {
      icon.classList.remove('fa-solid', 'is-favorited');
      icon.classList.add('fa-regular');
      btn.classList.remove('is-favorited');
    }

    if (j.count !== undefined) {
      const countEl = document.querySelector('.heart-item-box span');
      if (countEl) countEl.textContent = j.count;
    }

  }catch(err){}
});
</script>
@else
<script>
// If guest clicks the heart, send them to login
document.addEventListener('click',(e)=>{
  const btn = e.target.closest('.js-fav');
  if (!btn) return;
  window.location = '{{ route('login') }}';
});
</script>
@endauth

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.unfav-btn').forEach(function(button) {
        button.addEventListener('click', function () {
            if (confirm('Remove from favorites?')) {
                const orderId = this.dataset.id;

                fetch(`/favorites/unfav/${orderId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // 🔄 Reload after unfav
                    }
                });
            }
        });
    });
});
 document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit');
    const errorMessage = document.getElementById('error-message');
    let paymentErrorMsg = '';


    form.addEventListener('submit', function (e) {
      e.preventDefault(); // prevent form from submitting immediately


      console.log(e);
      console.log('dev');
      console.log(e.error);
      //  if (!paymentComplete || paymentErrorMsg) {
      //   errorMessage.textContent = paymentErrorMsg || 'Please complete your payment details.';
      //   submitButton.disabled = false;
      //   submitButton.textContent = 'Pay now';
      //   return;
      // }
      
      // Disable the button
      submitButton.disabled = true;
      // Optional: Change the text
      submitButton.textContent = 'Processing...';
      // Show progress message
      errorMessage.textContent = 'Payment is in progress, please wait for some time.';

      // 🧠 Here you would call Stripe or your payment processor logic.
      // For now, simulate it with a timeout
      
      setTimeout(() => {
        console.log(errorMessage.textContent);
        if (errorMessage.textContent != 'Payment is in progress, please wait for some time.') {
          submitButton.disabled = false;
          submitButton.textContent = 'Pay Now';
          errorMessage.textContent = '';  
        }
        form.submit(); // now allow form to continue
      }, 2000); // 2-second delay to simulate processing
    });
  });



    setTimeout(() => {
      $('.alert-danger').hide();
      $('#ajaxError').hide();
    }, 5000); // 2-second delay to simulate processing

</script>

</html>