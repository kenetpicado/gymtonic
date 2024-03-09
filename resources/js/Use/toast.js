import { createToaster } from "@meforma/vue-toaster";

export const toast = createToaster({
	position: "bottom",
	duration: 2000,
	maxToasts: 2,
});

export function created() {
    toast.success("Registro creado correctamente")
}
