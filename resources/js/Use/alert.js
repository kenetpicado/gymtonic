import Swal from "sweetalert2";

export function confirmAlert(onDone, message = "Are you sure?") {
    Swal.fire({
        icon: "info",
        iconColor: "#4f46e5",
        title: "Confirm",
        text: message,
        showCancelButton: true,
        confirmButtonText: "Yes. I'm sure",
        confirmButtonColor: "#4f46e5",
    }).then((result) => {
        if (result.isConfirmed) {
            onDone();
        }
    });
}