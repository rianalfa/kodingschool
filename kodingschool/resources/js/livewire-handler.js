// Notyf
    const notification = require("notyf");
    const notyf = new notification.Notyf({ duration: 3000 });

    Livewire.on("error", (message) => {
        notyf.error(message);
    });

    Livewire.on("success", (message) => {
        notyf.success(message);
    });

// Swal
    const Swal = require('sweetalert2');
    Livewire.on('swal', (type, message) => {
        Swal.fire({
            'icon': type,
            'title': '',
            'text': message,
            'buttonsStyling': false,
            'customClass': {
                'confirmButton': 'font-semibold text-sm tracking-widest bg-gray-700 hover:bg-gray-500 text-white rounded-md active:bg-gray-500 focus:border-gray-500 focus:ring-gray-400 anchor-button py-2 px-4'
            },
        });
    });

// Modal
    Livewire.on('openmodal', (id) => {
        document.getElementById(id).style.display='block';
    });

    Livewire.on('closemodal', (id) => {
        document.getElementById(id).style.display='none';
    });

//Console log
    Livewire.on('consolelog', (text) => {
        console.log(text);
    });
