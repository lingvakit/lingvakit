export function formatDate(courseDate: string): string {
    const date = new Date(courseDate);

    const day = date.getDate();
    const month = date.getMonth() + 1;
    const year = date.getFullYear();

    const pad = (n: number) => String(n).padStart(2, "0");
    return `${pad(day)}/${pad(month)}/${year}`;
}

export function formatDurationToText(totalMinutes: number): string {
    const hours = Math.floor(totalMinutes / 60);
    const minutes = totalMinutes % 60;

    const plural = (n: number, forms: [string, string, string]) => {
        const mod10 = n % 10;
        const mod100 = n % 100;

        if (mod10 === 1 && mod100 !== 11) return forms[0];
        if (mod10 >= 2 && mod10 <= 4 && (mod100 < 10 || mod100 >= 20)) return forms[1];

        return forms[2];
    };

    const parts: string[] = [];

    if (hours > 0) {
        parts.push(`${hours} ${plural(hours, ["час", "часа", "часов"])}`);
    }

    if (minutes > 0 || hours === 0) {
        parts.push(`${minutes} ${plural(minutes, ["минута", "минуты", "минут"])}`);
    }

    return parts.join(" ");
}
