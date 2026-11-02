<script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>

<script src="{{asset('assets/js/feather.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.slimscroll.min.js')}}"></script>

<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>

<script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>
<script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>

<script src="{{asset('assets/js/script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /** Global UI date format: dd/mm/yy */
    window.formatDate = function (dateStr) {
        if (!dateStr && dateStr !== 0) return '-';
        var s = String(dateStr).trim();
        if (!s || s === '-' || s === 'null') return '-';
        var iso = s.match(/^(\d{4})-(\d{2})-(\d{2})/);
        if (iso) {
            return iso[3] + '/' + iso[2] + '/' + iso[1].slice(-2);
        }
        var dmy = s.match(/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{2,4})/);
        if (dmy) {
            var yy = dmy[3].length === 4 ? dmy[3].slice(-2) : dmy[3];
            return String(dmy[1]).padStart(2, '0') + '/' + String(dmy[2]).padStart(2, '0') + '/' + yy;
        }
        var monNames = {jan:'01',feb:'02',mar:'03',apr:'04',may:'05',jun:'06',jul:'07',aug:'08',sep:'09',oct:'10',nov:'11',dec:'12'};
        var dMon = s.match(/^(\d{1,2})[\/\-]([A-Za-z]{3})[\/\-](\d{2,4})/);
        if (dMon && monNames[dMon[2].toLowerCase()]) {
            var yy2 = dMon[3].length === 4 ? dMon[3].slice(-2) : dMon[3];
            return String(dMon[1]).padStart(2, '0') + '/' + monNames[dMon[2].toLowerCase()] + '/' + yy2;
        }
        var d = new Date(s);
        if (isNaN(d.getTime())) return s;
        return String(d.getDate()).padStart(2, '0') + '/' +
            String(d.getMonth() + 1).padStart(2, '0') + '/' +
            String(d.getFullYear()).slice(-2);
    };

    /** Show dd/mm/yy + calendar button; native picker still used for choosing date */
    window.enhanceDateInputs = function (root) {
        (root || document).querySelectorAll('input[type="date"]:not([data-ddmmyy])').forEach(function (inp) {
            inp.setAttribute('data-ddmmyy', '1');

            var sm = (inp.className || '').indexOf('form-control-sm') !== -1;
            var canPick = !inp.readOnly && !inp.disabled;

            var group = document.createElement('div');
            group.className = 'input-group js-date-wrap' + (sm ? ' input-group-sm' : '');
            group.style.position = 'relative';
            inp.parentNode.insertBefore(group, inp);

            var display = document.createElement('input');
            display.type = 'text';
            display.className = 'form-control js-date-display bg-white' + (sm ? ' form-control-sm' : '');
            display.readOnly = true;
            display.placeholder = 'dd/mm/yy';
            display.value = inp.value ? window.formatDate(inp.value) : '';
            if (inp.disabled) display.disabled = true;
            group.appendChild(display);

            function openPicker(e) {
                if (e) e.preventDefault();
                if (!canPick) return;
                try {
                    if (typeof inp.showPicker === 'function') {
                        inp.showPicker();
                    } else {
                        inp.style.pointerEvents = 'auto';
                        inp.focus();
                        inp.click();
                        inp.style.pointerEvents = 'none';
                    }
                } catch (err) {
                    inp.style.pointerEvents = 'auto';
                    inp.focus();
                    inp.click();
                    inp.style.pointerEvents = 'none';
                }
            }

            if (canPick) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'btn btn-outline-secondary';
                btn.title = 'Select date';
                btn.innerHTML = '<i class="fas fa-calendar-alt"></i>';
                btn.addEventListener('click', openPicker);
                group.appendChild(btn);
                display.style.cursor = 'pointer';
                display.addEventListener('click', openPicker);
            }

            // Keep in form for submit; hide visually (picker opened via showPicker)
            inp.classList.add('js-date-native');
            inp.style.cssText = 'position:absolute;left:0;top:0;width:1px;height:1px;opacity:0;pointer-events:none;border:0;padding:0;margin:0;';
            group.appendChild(inp);

            function syncDisplay() {
                display.value = inp.value ? window.formatDate(inp.value) : '';
            }
            inp.addEventListener('change', syncDisplay);
            inp.addEventListener('input', syncDisplay);
            syncDisplay();
        });
    };

    document.addEventListener('DOMContentLoaded', function () {
        window.enhanceDateInputs(document);
        if (window.MutationObserver) {
            var obs = new MutationObserver(function (mutations) {
                mutations.forEach(function (m) {
                    m.addedNodes.forEach(function (node) {
                        if (node.nodeType !== 1) return;
                        if (node.matches && node.matches('input[type="date"]')) {
                            window.enhanceDateInputs(node.parentNode || document);
                        } else if (node.querySelectorAll) {
                            window.enhanceDateInputs(node);
                        }
                    });
                });
            });
            obs.observe(document.body, { childList: true, subtree: true });
        }
    });

    if (window.jQuery) {
        var _jqVal = jQuery.fn.val;
        jQuery.fn.val = function () {
            var result = _jqVal.apply(this, arguments);
            if (arguments.length > 0) {
                this.filter('input[type="date"][data-ddmmyy]').each(function () {
                    var wrap = this.closest ? this.closest('.js-date-wrap') : null;
                    var disp = wrap && wrap.querySelector('.js-date-display');
                    if (disp) disp.value = this.value ? window.formatDate(this.value) : '';
                });
            }
            return result;
        };
    }
</script>
<script>
    document.querySelectorAll('.js-logout').forEach(function (el) {
        el.addEventListener('click', function (e) {
            e.preventDefault();
            var url = this.getAttribute('href');
            Swal.fire({
                title: 'Logout?',
                text: 'Are you sure you want to logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00c4cc',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>