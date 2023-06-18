import { Carbon } from "./Carbon";

export class Plan {
    plan_id;
    amount;
    period;
    start_date;
    end_date;
    discount;
    note;
    service_id;

    TODAY;

    constructor(plan = null, service_id, isCurrentActive = null) {

        this.TODAY = new Carbon().format("Y-m-d");

        this.plan_id = plan?.id;
        this.amount = plan?.amount ?? 0;
        this.period = plan?.period;

        if (isCurrentActive === null) {
            this.start_date = plan?.start_date ?? this.TODAY;
        } else {
            this.start_date = isCurrentActive ? plan?.start_date : this.TODAY;
        }

        this.end_date = plan?.end_date;
        this.discount = plan?.discount ?? 0;
        this.note = plan?.note;
        this.service_id = plan?.service_id ?? service_id;
    }
}
