import { Carbon } from "./Carbon";

export class Plan {
    plan_id;
    price;
    period;
    start_date;
    end_date;
    discount;
    note;
    service_id;
    save_note;

    TODAY;

    constructor(plan = null, service_id, isCurrentActive = false) {

        this.TODAY = new Carbon().format("Y-m-d");

        this.plan_id = plan?.id;
        this.price = plan?.price ?? 0;
        this.period = plan?.period;

        if (!isCurrentActive) {
            this.start_date = plan?.start_date ?? this.TODAY;
        } else {
            this.start_date = plan?.end_date;
        }

        this.end_date = plan?.end_date;
        this.discount = plan?.discount ?? 0;
        this.note = plan?.note ?? "";
        this.service_id = plan?.service_id ?? service_id;
        this.save_note = false;
    }
}
