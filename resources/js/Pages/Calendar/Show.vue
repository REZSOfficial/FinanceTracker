<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { onMounted } from "vue";

const props = defineProps({
    incoming: { type: Array },
    outgoing: { type: Array },
});

const generateEvents = (data, type, color) => {
    const events = [];
    const today = new Date();
    const endOfYear = new Date(today.getFullYear(), 11, 31); // Until the end of the current year

    data.forEach((item) => {
        const startDate = new Date(item.created_at);

        if (item.regular) {
            // Generate recurring events until the end of the year
            while (startDate <= endOfYear) {
                const endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + item.period * 30); // Approximate period in days

                events.push({
                    title: `${item.title} (${type}) - $${item.amount}`,
                    start: new Date(startDate),
                    end: new Date(endDate),
                    allDay: true,
                    color: color,
                });

                // Move start date to the next period
                startDate.setMonth(startDate.getMonth() + item.period);
            }
        } else {
            // One-time event
            events.push({
                title: `${item.title} (${type}) - $${item.amount}`,
                start: new Date(startDate),
                allDay: true,
                color: color,
            });
        }
    });

    return events;
};

onMounted(() => {
    const calendarEl = document.getElementById("calendar");

    // Generate events from props
    const incomingEvents = generateEvents(
        props.incoming,
        "Incoming",
        "#32a852"
    );
    const outgoingEvents = generateEvents(
        props.outgoing,
        "Outgoing",
        "#a83a32"
    );

    // Initialize FullCalendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: "dayGridMonth",
        events: [...incomingEvents, ...outgoingEvents],
        editable: true,
        selectable: true,
    });

    calendar.render();
});
</script>

<style>
@import "https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css";
#calendar {
    max-width: 900px;
    margin: 40px auto;
    color: white;
}
</style>

<template>
    <AppLayout title="Calendar">
        <div class="w-full p-2 mx-auto mt-4 rounded md:w-3/4 glass">
            <div id="calendar"></div>
        </div>
    </AppLayout>
</template>
