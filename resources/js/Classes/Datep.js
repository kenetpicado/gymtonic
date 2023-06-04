export class Datep {
    date;

    DATE_UNITS = {
        year: 31536000,
        month: 2592000,
        day: 86400,
        hour: 3600,
        minute: 60,
        second: 1,
    };

    rtf = new Intl.RelativeTimeFormat(navigator.language, {
        numeric: "auto",
    });

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

        return format
            .replace("Y", year)
            .replace("m", month)
            .replace("d", day)
            .toString();
    }

    diffForHumans() {
        const currentTimestamp = Math.floor(Date.now() / 1000);
        const targetTimestamp = Math.floor(this.date.getTime() / 1000);
        const diff = currentTimestamp - targetTimestamp;

        for (const unit in this.DATE_UNITS) {
            if (diff >= this.DATE_UNITS[unit]) {
                const value = Math.floor(diff / this.DATE_UNITS[unit]);
                return this.rtf.format(-value, unit);
            }
        }

        return this.rtf.format(-diff, "second");
    }
}
