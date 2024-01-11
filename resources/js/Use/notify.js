import Swal from "sweetalert2";

export default function useNotify() {
    function success(message) {
        Swal.fire({
            icon: "success",
            title: "Success",
            text: message,
            position: "top-end",
            toast: "true",
            timer: 2000,
            showCancelButton: false,
            showConfirmButton: false,
        });
    }

    function error(message) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: message,
            position: "top-end",
            toast: "true",
            timer: 2000,
            showCancelButton: false,
            showConfirmButton: false,
        });
    }

    function confirm(done, message = "Estas seguro?") {
        Swal.fire({
            icon: "info",
            iconColor: "#4f46e5",
            title: "Confirmar",
            text: message,
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            confirmButtonColor: "#4f46e5",
        }).then((result) => {
            if (result.isConfirmed) {
                done();
            }
        });
    }

    return { success, error, confirm };
}