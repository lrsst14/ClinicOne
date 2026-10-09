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
