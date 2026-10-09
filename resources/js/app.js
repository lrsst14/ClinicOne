const chart = document.querySelector('[data-registration-chart]');

if (chart instanceof HTMLElement) {
    const chartSvg = chart.querySelector('[data-chart-svg]');
    const endpoint = chart.dataset.endpoint;
    const totalElement = document.querySelector('#registration-total');
    const statusElement = document.querySelector('#registration-chart-status');
    const svgNamespace = 'http://www.w3.org/2000/svg';
    const refreshInterval = 30_000;

    function createSvgElement(name, attributes = {}) {
        const element = document.createElementNS(svgNamespace, name);

        Object.entries(attributes).forEach(([key, value]) => {
            element.setAttribute(key, value);
        });

        return element;
    }

    function renderChart(days) {
        const width = 700;
        const height = 260;
        const left = 46;
        const right = 12;
        const top = 14;
        const bottom = 48;
        const plotWidth = width - left - right;
        const plotHeight = height - top - bottom;
        const maximum = Math.max(1, ...days.map((day) => day.count));
        const ticks = [...new Set([0, 1, 2, 3, 4].map((tick) => Math.ceil((maximum * tick) / 4)))];
        const points = days.map((day, index) => ({
            ...day,
            x: left + (plotWidth * index) / Math.max(days.length - 1, 1),
            y: top + plotHeight - (day.count / maximum) * plotHeight,
        }));

        chartSvg.replaceChildren();

        ticks.forEach((tick) => {
            const y = top + plotHeight - (tick / maximum) * plotHeight;
            const gridLine = createSvgElement('line', {
                x1: left,
                x2: width - right,
                y1: y,
                y2: y,
                stroke: '#e7edf6',
                'stroke-width': '1',
            });
            const label = createSvgElement('text', {
                x: left - 12,
                y: y + 4,
                fill: '#8092ad',
                'font-size': '11',
                'text-anchor': 'end',
            });

            label.textContent = tick.toLocaleString('id-ID');
            chartSvg.append(gridLine, label);
        });

        chartSvg.append(
            createSvgElement('path', {
                d: points.map((point, index) => `${index === 0 ? 'M' : 'L'} ${point.x} ${point.y}`).join(' '),
                fill: 'none',
                stroke: '#38bdf8',
                'stroke-width': '3',
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
            }),
        );

        points.forEach((point) => {
            const date = new Date(`${point.date}T00:00:00`);
            const label = new Intl.DateTimeFormat('id-ID', {
                day: 'numeric',
                month: 'short',
            }).format(date);
            const circle = createSvgElement('circle', {
                cx: point.x,
                cy: point.y,
                r: '5',
                fill: '#ffffff',
                stroke: '#38bdf8',
                'stroke-width': '3',
            });
            const tooltip = createSvgElement('title');
            const dateLabel = createSvgElement('text', {
                x: point.x,
                y: height - 12,
                fill: '#8092ad',
                'font-size': '11',
                'text-anchor': 'middle',
            });

            tooltip.textContent = `${label}: ${point.count.toLocaleString('id-ID')} akun`;
            dateLabel.textContent = label;
            circle.append(tooltip);
            chartSvg.append(circle, dateLabel);
        });
    }

    async function refreshChart() {
        try {
            const response = await fetch(endpoint, {
                headers: { Accept: 'application/json' },
                cache: 'no-store',
            });

            if (!response.ok) {
                throw new Error(`Permintaan grafik gagal (${response.status}).`);
            }

            const data = await response.json();

            if (
                !Array.isArray(data.days)
                || !Number.isSafeInteger(data.total)
                || !data.days.every((day) =>
                    typeof day.date === 'string'
                    && /^\d{4}-\d{2}-\d{2}$/.test(day.date)
                    && Number.isSafeInteger(day.count)
                    && day.count >= 0)
            ) {
                throw new Error('Format data grafik dari server tidak valid.');
            }

            renderChart(data.days);
            totalElement.textContent = data.total.toLocaleString('id-ID');
            const updatedAt = new Date(data.updatedAt);
            const updatedTime = Number.isNaN(updatedAt.getTime())
                ? ''
                : ` Terakhir diperbarui ${new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                }).format(updatedAt)}.`;

            statusElement.textContent = `Pembaruan otomatis setiap 30 detik.${updatedTime}`;
        } catch (error) {
            statusElement.textContent = 'Grafik gagal diperbarui. Mencoba kembali dalam 30 detik.';
            console.error('Gagal memuat grafik pendaftaran akun.', error);
        } finally {
            window.setTimeout(refreshChart, refreshInterval);
        }
    }

    if (chartSvg instanceof SVGElement && endpoint && totalElement instanceof HTMLElement && statusElement instanceof HTMLElement) {
        refreshChart();
    }
}
const accessForm = document.querySelector('[data-doctor-login-form]');
const accessInput = document.querySelector('#access-code');
const accessToggle = document.querySelector('[data-toggle-access-code]');
const forgotAccessCode = document.querySelector('[data-forgot-access-code]');
const feedback = document.querySelector('#doctor-login-feedback');

const doctorSidebar = document.querySelector('[data-doctor-sidebar]');
const doctorSidebarToggle = document.querySelector('[data-doctor-sidebar-toggle]');
const doctorSidebarOverlay = document.querySelector('[data-doctor-sidebar-overlay]');
const doctorSidebarMain = document.querySelector('[data-doctor-main]');
const desktopSidebarQuery = window.matchMedia('(min-width: 768px)');

const setDoctorSidebarOpen = (isOpen) => {
	if (!doctorSidebar || !doctorSidebarToggle || !doctorSidebarOverlay || !doctorSidebarMain) {
		return;
	}

	doctorSidebar.classList.toggle('-translate-x-full', !isOpen);
	doctorSidebar.style.transform = desktopSidebarQuery.matches && !isOpen ? 'translateX(-100%)' : '';
	doctorSidebarMain.style.marginLeft = desktopSidebarQuery.matches && !isOpen ? '0' : '';
	doctorSidebarOverlay.classList.toggle('hidden', !isOpen);
	doctorSidebarToggle.setAttribute('aria-expanded', String(isOpen));
	doctorSidebarToggle.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
	document.body.classList.toggle('overflow-hidden', isOpen && !desktopSidebarQuery.matches);
};

setDoctorSidebarOpen(desktopSidebarQuery.matches);

doctorSidebarToggle?.addEventListener('click', () => {
	setDoctorSidebarOpen(doctorSidebarToggle.getAttribute('aria-expanded') !== 'true');
});

doctorSidebarOverlay?.addEventListener('click', () => {
	setDoctorSidebarOpen(false);
});

doctorSidebar?.querySelectorAll('nav a').forEach((link) => {
	link.addEventListener('click', () => {
		if (!desktopSidebarQuery.matches) {
			setDoctorSidebarOpen(false);
		}
	});
});

desktopSidebarQuery.addEventListener('change', (event) => {
	setDoctorSidebarOpen(event.matches);
});

const showFeedback = (message) => {
	if (!feedback) {
		return;
	}

	feedback.textContent = message;
	feedback.classList.remove('hidden');
};

accessToggle?.addEventListener('click', () => {
	if (!accessInput) {
		return;
	}

	const isVisible = accessInput.type === 'text';
	accessInput.type = isVisible ? 'password' : 'text';
	accessToggle.setAttribute('aria-pressed', String(!isVisible));
	accessToggle.setAttribute('aria-label', isVisible ? 'Tampilkan kode akses' : 'Sembunyikan kode akses');
});

accessForm?.addEventListener('submit', (event) => {
	if (!accessInput || accessInput.value.trim().length >= 4) {
		return;
	}

	event.preventDefault();
	showFeedback('Kode akses minimal 4 karakter.');
});

forgotAccessCode?.addEventListener('click', () => {
	showFeedback('Hubungi admin klinik untuk mendapatkan kode akses yang aktif.');
});

const appointmentModal = document.querySelector('[data-appointment-modal]');
const appointmentDetailButtons = document.querySelectorAll('[data-appointment-details]');
const appointmentModalCloseButtons = appointmentModal?.querySelectorAll('[data-close-appointment-modal]');
const appointmentDetailFields = {
	initials: appointmentModal?.querySelector('[data-detail-initials]'),
	name: appointmentModal?.querySelector('[data-detail-name]'),
	nik: appointmentModal?.querySelector('[data-detail-nik]'),
	phone: appointmentModal?.querySelector('[data-detail-phone]'),
	birth: appointmentModal?.querySelector('[data-detail-birth]'),
	status: appointmentModal?.querySelector('[data-detail-status]'),
	date: appointmentModal?.querySelector('[data-detail-date]'),
	time: appointmentModal?.querySelector('[data-detail-time]'),
	complaint: appointmentModal?.querySelector('[data-detail-complaint]'),
	pendingNotice: appointmentModal?.querySelector('[data-pending-notice]'),
};
let appointmentModalTrigger;

const closeAppointmentModal = () => {
	if (!appointmentModal) {
		return;
	}

	appointmentModal.classList.add('hidden');
	appointmentModal.classList.remove('flex');
	appointmentModal.setAttribute('aria-hidden', 'true');
	document.body.classList.remove('overflow-hidden');
	appointmentModalTrigger?.focus();
};

appointmentDetailButtons.forEach((button) => {
	button.addEventListener('click', () => {
		if (!appointmentModal) {
			return;
		}

		const appointment = button.dataset;
		const statusClasses = {
			Menunggu: 'bg-[#fff7e7] text-[#c98b00]',
			Dikonfirmasi: 'bg-[#edf4ff] text-[#2d6ef5]',
			Selesai: 'bg-[#eaf9f1] text-[#1da35a]',
			Ditolak: 'bg-[#fff1f1] text-[#d14a4a]',
		};

		appointmentDetailFields.initials.textContent = appointment.initials ?? '';
		appointmentDetailFields.name.textContent = appointment.name ?? '';
		appointmentDetailFields.nik.textContent = appointment.nik ?? '';
		appointmentDetailFields.phone.textContent = appointment.phone ?? '';
		appointmentDetailFields.birth.textContent = appointment.birth ?? '';
		appointmentDetailFields.date.textContent = appointment.date ?? '';
		appointmentDetailFields.time.textContent = appointment.time ?? '';
		appointmentDetailFields.complaint.textContent = appointment.complaint ?? '';
		appointmentDetailFields.status.textContent = appointment.status ?? '';
		appointmentDetailFields.status.className = `mt-1 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ${statusClasses[appointment.status] ?? 'bg-slate-100 text-slate-600'}`;
		appointmentDetailFields.pendingNotice.classList.toggle('hidden', appointment.status !== 'Menunggu');
		appointmentDetailFields.pendingNotice.classList.toggle('flex', appointment.status === 'Menunggu');

		appointmentModalTrigger = button;
		appointmentModal.classList.remove('hidden');
		appointmentModal.classList.add('flex');
		appointmentModal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('overflow-hidden');
		appointmentModal.querySelector('[data-close-appointment-modal]')?.focus();
	});
});

appointmentModalCloseButtons?.forEach((button) => {
	button.addEventListener('click', closeAppointmentModal);
});

appointmentModal?.addEventListener('click', (event) => {
	if (event.target === appointmentModal) {
		closeAppointmentModal();
	}
});

document.addEventListener('keydown', (event) => {
	if (event.key === 'Escape' && doctorSidebarToggle?.getAttribute('aria-expanded') === 'true') {
		setDoctorSidebarOpen(false);
		doctorSidebarToggle.focus();
	}

	if (event.key === 'Escape' && appointmentModal?.getAttribute('aria-hidden') === 'false') {
		closeAppointmentModal();
	}
});
