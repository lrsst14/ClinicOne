const chart = document.querySelector('[data-registration-chart]');

if (chart instanceof HTMLElement) {
    const chartSvg = chart.querySelector('[data-chart-svg]');
    const endpoint = chart.dataset.endpoint;
    const totalElement = document.querySelector('#registration-total');
    const statusElement = document.querySelector('#registration-chart-status');
    const svgNamespace = 'http://www.w3.org/2000/svg';
    const refreshInterval = 30_000;

    function createSvgElement(name, attributes = {}) {
        const element = document.createElementNS(svgNamespace, name);

        Object.entries(attributes).forEach(([key, value]) => {
            element.setAttribute(key, value);
        });

        return element;
    }

    function renderChart(days) {
        const width = 700;
        const height = 260;
        const left = 46;
        const right = 12;
        const top = 14;
        const bottom = 48;
        const plotWidth = width - left - right;
        const plotHeight = height - top - bottom;
        const maximum = Math.max(1, ...days.map((day) => day.count));
        const ticks = [...new Set([0, 1, 2, 3, 4].map((tick) => Math.ceil((maximum * tick) / 4)))];
        const points = days.map((day, index) => ({
            ...day,
            x: left + (plotWidth * index) / Math.max(days.length - 1, 1),
            y: top + plotHeight - (day.count / maximum) * plotHeight,
        }));

        chartSvg.replaceChildren();

        ticks.forEach((tick) => {
            const y = top + plotHeight - (tick / maximum) * plotHeight;
            const gridLine = createSvgElement('line', {
                x1: left,
                x2: width - right,
                y1: y,
                y2: y,
                stroke: '#334155',
                'stroke-width': '1',
            });
            const label = createSvgElement('text', {
                x: left - 12,
                y: y + 4,
                fill: '#94a3b8',
                'font-size': '11',
                'text-anchor': 'end',
            });

            label.textContent = tick.toLocaleString('id-ID');
            chartSvg.append(gridLine, label);
        });

        chartSvg.append(
            createSvgElement('path', {
                d: points.map((point, index) => `${index === 0 ? 'M' : 'L'} ${point.x} ${point.y}`).join(' '),
                fill: 'none',
                stroke: '#38bdf8',
                'stroke-width': '3',
                'stroke-linecap': 'round',
                'stroke-linejoin': 'round',
            }),
        );

        points.forEach((point) => {
            const date = new Date(`${point.date}T00:00:00`);
            const label = new Intl.DateTimeFormat('id-ID', {
                day: 'numeric',
                month: 'short',
            }).format(date);
            const circle = createSvgElement('circle', {
                cx: point.x,
                cy: point.y,
                r: '5',
                fill: '#0f172a',
                stroke: '#38bdf8',
                'stroke-width': '3',
            });
            const tooltip = createSvgElement('title');
            const dateLabel = createSvgElement('text', {
                x: point.x,
                y: height - 12,
                fill: '#94a3b8',
                'font-size': '11',
                'text-anchor': 'middle',
            });

            tooltip.textContent = `${label}: ${point.count.toLocaleString('id-ID')} akun`;
            dateLabel.textContent = label;
            circle.append(tooltip);
            chartSvg.append(circle, dateLabel);
        });
    }

    async function refreshChart() {
        try {
            const response = await fetch(endpoint, {
                headers: { Accept: 'application/json' },
                cache: 'no-store',
            });

            if (!response.ok) {
                throw new Error(`Permintaan grafik gagal (${response.status}).`);
            }

            const data = await response.json();

            if (
                !Array.isArray(data.days)
                || !Number.isSafeInteger(data.total)
                || !data.days.every((day) =>
                    typeof day.date === 'string'
                    && /^\d{4}-\d{2}-\d{2}$/.test(day.date)
                    && Number.isSafeInteger(day.count)
                    && day.count >= 0)
            ) {
                throw new Error('Format data grafik dari server tidak valid.');
            }

            renderChart(data.days);
            totalElement.textContent = data.total.toLocaleString('id-ID');
            const updatedAt = new Date(data.updatedAt);
            const updatedTime = Number.isNaN(updatedAt.getTime())
                ? ''
                : ` Terakhir diperbarui ${new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                }).format(updatedAt)}.`;

            statusElement.textContent = `Pembaruan otomatis setiap 30 detik.${updatedTime}`;
        } catch (error) {
            statusElement.textContent = 'Grafik gagal diperbarui. Mencoba kembali dalam 30 detik.';
            console.error('Gagal memuat grafik pendaftaran akun.', error);
        } finally {
            window.setTimeout(refreshChart, refreshInterval);
        }
    }

    if (chartSvg instanceof SVGElement && endpoint && totalElement instanceof HTMLElement && statusElement instanceof HTMLElement) {
        refreshChart();
    }
}