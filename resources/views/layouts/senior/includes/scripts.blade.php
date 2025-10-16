<script src="{{ asset('caregiver/assets/js/jquery.js') }}"></script>
<script src="{{ asset('caregiver/assets/js/custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    document.querySelectorAll('.user-dropdown').forEach(function(elem) {
        elem.addEventListener('click', function() {
            const dropdown = this.querySelector('.dropdown-content');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        });
    });
</script>

<script>
    // menu sidebar
    document.querySelector('.btnToggle').addEventListener('click', function() {
        document.querySelector('.main-content').classList.toggle('collapsed');
        document.querySelector('.sidebar').classList.toggle('collapsed');
    });
</script>




<script>
    @if (session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'Ok'
        })
    @endif
    @if (session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonText: 'Ok'
        })
    @endif
    @if (session('warning'))
        Swal.fire({
            title: 'Warning!',
            text: '{{ session('warning') }}',
            icon: 'warning',
            confirmButtonText: 'Ok'
        })
    @endif
</script>
@stack('js')


<script>
    new WOW().init();
</script>
