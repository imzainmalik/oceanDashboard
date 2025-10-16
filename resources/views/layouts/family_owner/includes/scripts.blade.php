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



<!-- FullCalendar   -->
<script>
    let calendar;
    let selectedInfo = null;

    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            select: function(info) {
                selectedInfo = info;
                document.getElementById('noteText').value = '';
                document.getElementById('noteColor').value = '#3788d8';
                document.getElementById('noteModal').style.display = 'block';
            }
        });

        calendar.render();

        // Month Buttons
        const monthNames = [
            "January", "February", "March", "April",
            "May", "June", "July", "August",
            "September", "October", "November", "December"
        ];

        const monthButtonsContainer = document.getElementById('month-buttons');
        const currentYear = new Date().getFullYear();

        monthNames.forEach((month, index) => {
            const btn = document.createElement('div');
            btn.className = 'month-btn';
            btn.textContent = month;
            btn.addEventListener('click', () => {
                const newDate = new Date(currentYear, index, 1);
                calendar.gotoDate(newDate);
            });
            monthButtonsContainer.appendChild(btn);
        });
    });

    function saveNote() {
        const note = document.getElementById('noteText').value.trim();
        const color = document.getElementById('noteColor').value;

        if (note && selectedInfo) {
            calendar.addEvent({
                title: note,
                start: selectedInfo.startStr,
                end: selectedInfo.endStr,
                allDay: true,
                backgroundColor: color,
                borderColor: color
            });
        }

        document.getElementById('noteModal').style.display = 'none';
    }

    // Close modal on background click
    window.onclick = function(event) {
        const modal = document.getElementById('noteModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
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
