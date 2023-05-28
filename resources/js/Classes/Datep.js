export class Datep {
    date;

    constructor(dateString) {
        if (!dateString) {
            this.date = new Date();
        } else {
            this.date = new Date(dateString);
        }
    }

    addMonth(month = 1) {
        this.date.setMonth(this.date.getMonth() + month);
        return this;
    }

    addDays(days = 1) {
        this.date.setDate(this.date.getDate() + days);
        return this;
    }

    addPeriod(period) {
        if (period == 30) {
            this.addMonth();
        } else {
            this.addDays(period);
        }

        return this;
    }

    format(format = "Y-m-d") {
        let year = this.date.getFullYear();
        let month = this.date.getMonth() + 1;
        let day = this.date.getDate();

        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        return (format.replace("Y", year).replace("m", month).replace("d", day)).toString();
    }
}
