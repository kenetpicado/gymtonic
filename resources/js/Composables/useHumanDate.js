export default function useHumanDate() {
    const DATE_UNITS = {
        year: 31536000,
        month: 2592000,
        day: 86400,
        hour: 3600,
        minute: 60,
        second: 1,
    };

    const rtf = new Intl.RelativeTimeFormat(navigator.language, {
        numeric: "auto",
    });

    function diffForHumans(timestamp) {
        const currentTimestamp = Math.floor(Date.now() / 1000);
        const targetTimestamp = Math.floor(
            new Date(timestamp).getTime() / 1000
        );
        const diff = currentTimestamp - targetTimestamp;

        for (const unit in DATE_UNITS) {
            if (diff >= DATE_UNITS[unit]) {
                const value = Math.floor(diff / DATE_UNITS[unit]);
                return rtf.format(-value, unit);
            }
        }

        return rtf.format(-diff, "second");
    }

    return { diffForHumans };
}
