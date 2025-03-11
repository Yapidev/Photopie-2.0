$wire.on("notify", (data) => {
    Swal.fire({
        icon: data.icon,
        title: data.title,
        text: data.message,
        timer: 2000,
        showConfirmButton: false,
    });
});
