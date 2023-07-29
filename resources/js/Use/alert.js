import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { toast } from "@/Use/toast";

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

export function addStarsInput(id) {
    Swal.fire({
        title: "Agregar estrellas",
        input: "number",
        inputLabel: "Ingrese la cantidad de estrellas",
        showCancelButton: false,
        confirmButtonColor: "#1f2937",
        confirmButtonText: "Agregar",
    }).then((result) => {
        if (result.isConfirmed) {
            router.put(
                route("dashboard.stars.update", id),
                {
                    value: result.value,
                },
                {
                    preserveState: true,
                    preserveScroll: true,
                    onSuccess: () => {
                        toast.success("Estrellas agregadas correctamente!");
                    },
                }
            );
        }
    });
}
