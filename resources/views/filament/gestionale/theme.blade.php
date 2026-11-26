{{--
    Look of the physiotherapy panel (/gestionale): dark sidebar, light content,
    indigo accents, dark table headers and coloured modal headers.
    Plain CSS on top of Filament's own classes, so no Tailwind build is needed.
--}}
<style>
    :root {
        --gest-sidebar-bg: #1f2937;
        --gest-sidebar-active-bg: #111827;
        --gest-sidebar-text: #e5e7eb;
        --gest-sidebar-muted: #9ca3af;
        --gest-content-bg: #f3f4f6;
        --gest-table-head-bg: #1f2937;
        --gest-accent: #4f46e5;
    }

    /* ---------- Content area ---------- */
    .fi-body { background-color: var(--gest-content-bg); }

    /* Full-width white band behind the page title, with a line under it */
    .fi-page-header-main-ctn > .fi-header {
        position: relative;
        isolation: isolate;
        padding-bottom: calc(var(--spacing) * 8);
        margin-bottom: calc(var(--spacing) * 0);
    }
    .fi-page-header-main-ctn > .fi-header::before {
        content: '';
        position: absolute;
        z-index: -1;
        inset: calc(var(--spacing) * -8) -100vw 0 -100vw;
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }
    .fi-main-ctn { overflow-x: clip; }

    /* ---------- Sidebar ---------- */
    .fi-sidebar,
    .fi-sidebar.fi-sidebar-open { background-color: var(--gest-sidebar-bg) !important; }
    .fi-sidebar-header { background-color: var(--gest-sidebar-bg); box-shadow: none; border-bottom: 1px solid rgb(255 255 255 / .06); }
    .fi-sidebar .fi-logo { color: #fff; }
    .fi-sidebar-nav { padding-inline: 0; }
    .fi-sidebar-group-label { color: var(--gest-sidebar-muted); }

    .fi-sidebar-item-btn { border-radius: 0; padding-inline: calc(var(--spacing) * 5); padding-block: calc(var(--spacing) * 3); }
    .fi-sidebar-item-label { color: var(--gest-sidebar-text); font-size: 0.95rem; }
    .fi-sidebar-item-btn > .fi-icon { color: var(--gest-sidebar-text); }

    .fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:hover,
    .fi-sidebar-item.fi-sidebar-item-has-url > .fi-sidebar-item-btn:focus-visible { background-color: rgb(255 255 255 / .06); }

    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn {
        background-color: var(--gest-sidebar-active-bg);
        box-shadow: inset 3px 0 0 var(--gest-accent);
    }
    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn > .fi-sidebar-item-label,
    .fi-sidebar-item.fi-active > .fi-sidebar-item-btn > .fi-icon { color: #fff; }

    /* Search field and user menu at the bottom of the sidebar */
    .fi-sidebar .fi-global-search-field .fi-input-wrp { background-color: rgb(255 255 255 / .06); --tw-ring-color: rgb(255 255 255 / .12); }
    .fi-sidebar .fi-global-search-field input { color: #fff; }
    .fi-sidebar .fi-global-search-field .fi-icon { color: var(--gest-sidebar-muted); }
    .fi-sidebar-footer { border-color: rgb(255 255 255 / .1) !important; }
    .fi-sidebar .fi-user-menu-trigger,
    .fi-sidebar .fi-user-menu-trigger-text { color: var(--gest-sidebar-text); }
    .fi-sidebar .fi-user-menu-trigger:hover { background-color: rgb(255 255 255 / .06); }
    .fi-sidebar .fi-user-menu-trigger .fi-icon { color: var(--gest-sidebar-muted); }
    .fi-sidebar .fi-icon-btn { color: var(--gest-sidebar-muted); }

    /* Mobile: button that opens the sidebar */
    .fi-layout-sidebar-toggle-btn-ctn { background-color: #fff; border-bottom: 1px solid #e5e7eb; }

    /* ---------- Tables: dark header row ---------- */
    .fi-ta-table > thead > tr { background-color: var(--gest-table-head-bg); }
    .fi-ta-table > thead .fi-ta-header-cell,
    .fi-ta-table > thead .fi-ta-header-cell button,
    .fi-ta-table > thead .fi-ta-header-cell .fi-icon {
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-size: 0.8rem;
    }
    .fi-ta-table > thead .fi-checkbox-input { background-color: #fff; }
    .fi-ta-table > thead th:first-child { border-top-left-radius: var(--radius-xl); }
    .fi-ta-table > thead th:last-child { border-top-right-radius: var(--radius-xl); }

    /* "1 selezionato · Deseleziona · Archivia selezionati" bar */
    .fi-ta-ctn .fi-ta-selection-indicator {
        background-color: var(--gest-table-head-bg);
        border-color: var(--gest-table-head-bg);
        color: #fff;
    }
    .fi-ta-ctn .fi-ta-selection-indicator,
    .fi-ta-ctn .fi-ta-selection-indicator * { color: #fff; }
    .fi-ta-ctn .fi-ta-selection-indicator .fi-link { text-decoration: underline; }

    /* Toolbar: wide search field on the left, "Filtri" button on the right */
    .fi-ta-ctn .fi-ta-header-toolbar > div:last-of-type { flex: 1; margin-inline-start: 0; }
    .fi-ta-ctn .fi-ta-header-toolbar .fi-ta-search-field { flex: 1; }
    .fi-ta-ctn .fi-ta-header-toolbar .fi-ta-search-field .fi-input-wrp { max-width: none; }

    /* ---------- Modals ---------- */
    /* Form modals: indigo header band with white title */
    .fi-modal-window:not(.fi-align-center) > .fi-modal-header {
        background-color: var(--gest-accent);
        padding-block: calc(var(--spacing) * 5);
        border-top-left-radius: var(--radius-xl);
        border-top-right-radius: var(--radius-xl);
    }
    .fi-modal-window:not(.fi-align-center) > .fi-modal-header .fi-modal-heading { color: #fff; font-size: 1.25rem; }
    .fi-modal-window:not(.fi-align-center) > .fi-modal-header .fi-modal-close-btn,
    .fi-modal-window:not(.fi-align-center) > .fi-modal-header .fi-modal-close-btn .fi-icon { color: #fff; }
    .fi-modal-window:not(.fi-align-center) > .fi-modal-header + .fi-modal-content { padding-top: calc(var(--spacing) * 6); }

    /* "(opzionale)" next to the label of optional fields */
    .gest-optional { color: #6b7280; font-weight: 400; }

    /* Confirmation modals: indigo title */
    .fi-modal-window.fi-align-center .fi-modal-heading { color: var(--gest-accent); font-size: 1.25rem; }

    /* Form sections inside modals: small uppercase headings, no boxes */
    .fi-modal .fi-section { box-shadow: none; --tw-ring-shadow: 0 0 #0000; background: transparent; }
    .fi-modal .fi-section-header { padding-inline: 0; }
    .fi-modal .fi-section-content-ctn { border-top: 0; }
    .fi-modal .fi-section-content { padding-inline: 0; }
    .fi-modal .fi-section-header-heading { text-transform: uppercase; letter-spacing: 0.05em; font-size: 0.8rem; font-weight: 700; }
    .fi-modal .fi-section + .fi-section { border-top: 1px solid #e5e7eb; padding-top: calc(var(--spacing) * 2); }
    /* ---------- Dark page sections (patient form and page) ---------- */
    /* Rounded header instead of overflow: hidden, which would cut off the select menus */
    .gest-dark-section > .fi-section > .fi-section-header { border-top-left-radius: var(--radius-xl); border-top-right-radius: var(--radius-xl); }
    .gest-dark-section > .fi-section.fi-collapsed > .fi-section-header { border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl); }
    .gest-dark-section > .fi-section > .fi-section-header { background: var(--gest-sidebar-bg); padding: 1.1rem 1.5rem; }
    .gest-dark-section > .fi-section > .fi-section-header > .fi-icon,
    .gest-dark-section > .fi-section > .fi-section-header .fi-section-header-heading { color: #fff; }
    .gest-dark-section > .fi-section > .fi-section-header .fi-section-header-heading { font-size: 1.2rem; font-weight: 500; }
    .gest-dark-section > .fi-section > .fi-section-header .fi-section-header-text-ctn { display: grid; grid-template-columns: minmax(10rem, 30%) 1fr; align-items: center; gap: 1rem; }
    .gest-dark-section > .fi-section > .fi-section-header .fi-section-header-description { color: #9ca3af; margin: 0; }
    .gest-dark-section > .fi-section > .fi-section-header .fi-section-collapse-btn,
    .gest-dark-section > .fi-section > .fi-section-header .fi-section-collapse-btn .fi-icon { color: #fff; }
    .gest-dark-section > .fi-section > .fi-section-header .gest-section-header-link,
    .gest-dark-section > .fi-section > .fi-section-header .gest-section-header-link .fi-icon { color: #fff; }
    .gest-dark-section > .fi-section > .fi-section-content-ctn { border-top: 0; }
    .gest-dark-section > .fi-section > .fi-section-content-ctn > .fi-section-content { padding: 1.5rem 2.5rem 2rem; }
    .gest-divided { border-top: 4px solid #e5e7eb; padding-top: 1.25rem; }
    .gest-representatives .fi-fo-repeater-item { border: 1px solid #e5e7eb; box-shadow: none; }
    .gest-dark-section .fi-empty-state { padding-block: 1rem 1.5rem; }
    .gest-representative-summary { color: #6b7280; font-size: 0.875rem; }

    /* Modal with a dark header and the main button on the right (representatives) */
    .fi-modal-window.gest-dark-modal > .fi-modal-header { background-color: #1f2937; }
    .fi-modal-window.gest-dark-modal .fi-modal-footer { border-top: 1px solid #e5e7eb; background: #f9fafb; padding-top: 1rem; border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl); }
    .fi-modal-window.gest-dark-modal .fi-modal-footer-actions { flex-direction: row-reverse; justify-content: space-between; width: 100%; }
    .fi-modal-window.gest-dark-modal .fi-section-header-heading { text-transform: none; letter-spacing: normal; font-size: 1.05rem; }

    /* ---------- Patient list ---------- */
    .gest-patient-cell { display: flex; align-items: center; gap: 0.9rem; }
    .gest-patient-name { font-weight: 500; color: #111827; }
    .gest-patient-email { color: #6b7280; font-size: 0.875rem; }
    .gest-status-dot { flex: none; width: 0.85rem; height: 0.85rem; border-radius: 9999px; }
    .gest-status-dot-on { background: #4ade80; }
    .gest-status-dot-off { background: #d1d5db; }
    .gest-status-select { max-width: 10rem; min-height: 2.25rem; }

    /* ---------- Accounting page ---------- */
    .gest-accounting { display: flex; flex-direction: column; gap: 1.25rem; }
    .gest-accounting-cards { display: grid; grid-template-columns: minmax(16rem, 2fr) 4fr; gap: 1rem; }
    @media (max-width: 64rem) { .gest-accounting-cards { grid-template-columns: 1fr; } }
    .gest-month-card { background: linear-gradient(135deg, #111827, #374151); color: #fff; border-radius: var(--radius-xl); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem 1rem; text-align: center; }
    .gest-month-card-title { font-size: 1.35rem; font-weight: 700; }
    .gest-month-card-amount { font-size: 2.5rem; font-weight: 800; margin: 0.5rem 0; }
    .gest-month-card-note { color: #e5e7eb; }
    .gest-info-card { background: #fff; border-radius: var(--radius-xl); box-shadow: 0 1px 3px #0000001a; padding: 1.5rem; }
    .gest-info-card-header { display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem; }
    .gest-info-card-header h2 { font-size: 1.15rem; font-weight: 700; color: #111827; }
    .gest-info-card-tools { display: flex; align-items: center; gap: 0.5rem; }
    .gest-accent { color: var(--gest-accent); }
    .gest-outline-select { border-color: var(--gest-accent); color: var(--gest-accent); max-width: 7rem; }
    .gest-outline-btn { display: inline-flex; align-items: center; gap: 0.4rem; border: 1px solid var(--gest-accent); color: var(--gest-accent); border-radius: 0.5rem; padding: 0.35rem 0.75rem; font-size: 0.875rem; }
    .gest-outline-btn:disabled { opacity: 0.55; cursor: not-allowed; }
    .gest-info-card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; }
    .gest-figure-title { font-weight: 700; font-size: 1.05rem; color: #111827; }
    .gest-figure-sub { color: #6b7280; font-size: 0.875rem; }
    .gest-figure { font-size: 1.9rem; font-weight: 800; margin: 0.35rem 0; }
    .gest-figure-indigo { color: var(--gest-accent); }
    .gest-figure-green { color: #16a34a; }
    .gest-figure-red { color: #dc2626; }
    .gest-tabs { display: flex; gap: 0.6rem; flex-wrap: wrap; }
    .gest-tab { background: #e5e7eb; color: #374151; border-radius: 0.5rem; padding: 0.45rem 0.9rem; font-weight: 600; font-size: 0.95rem; }
    .gest-tab:hover { background: #d1d5db; }
    .gest-tab-active, .gest-tab-active:hover { background: var(--gest-accent); color: #fff; }
    .gest-wip-box { background: #fff; border-radius: var(--radius-xl); box-shadow: 0 1px 3px #0000001a; padding: 3rem 1rem; text-align: center; }
    .gest-wip-icon { width: 2.5rem; height: 2.5rem; margin: 0 auto 0.75rem; color: #9ca3af; }
    .gest-wip-title { font-weight: 700; font-size: 1.1rem; color: #111827; }
    .gest-wip-text { color: #6b7280; }

    /* ---------- "Nuovo documento contabile" ---------- */
    .gest-field-label { font-size: 0.875rem; font-weight: 500; color: #111827; }
    .gest-required { color: #dc2626; margin-left: 0.1rem; }
    .gest-paid-group { gap: 0.5rem; }
    .gest-paid-box { border-radius: 0.5rem; padding: 0.55rem 0.75rem; }
    .gest-paid-box-off { background: #fde2e2; }
    .gest-paid-box-off .fi-fo-field-label-content { color: #991b1b; }
    .gest-paid-box-on { background: #dcfce7; }
    .gest-paid-box-on .fi-fo-field-label-content { color: #166534; }
    .gest-invoice-lines .fi-fo-repeater-item { border: 0; box-shadow: none; }
    .gest-invoice-lines .fi-fo-repeater-item-header { padding-inline: 0; }
    .gest-invoice-lines .fi-fo-repeater-item-content { padding-inline: 0; }
    .gest-badge-default { display: inline-block; background: #22c55e; color: #fff; border-radius: 9999px; padding: 0 0.6rem; font-size: 0.8rem; margin-left: 0.4rem; }
    .gest-invoice-bar { position: sticky; bottom: 0; z-index: 20; display: flex; justify-content: space-between; align-items: flex-end; gap: 1rem; background: #fff; border-top: 1px solid #e5e7eb; box-shadow: 0 -4px 12px #0000000f; margin-inline: calc(var(--spacing) * -8); padding: 1rem calc(var(--spacing) * 8); }
    .gest-invoice-totals { min-width: 16rem; }
    .gest-invoice-row { display: flex; justify-content: space-between; gap: 2rem; color: #374151; }
    .gest-invoice-total { font-weight: 700; font-size: 1.2rem; color: #111827; }
    .gest-invoice-warning { color: #b45309; font-size: 0.85rem; margin-top: 0.25rem; }
    .gest-invoice-actions { display: flex; align-items: center; gap: 1.5rem; }
    .gest-invoice-back { display: inline-flex; align-items: center; gap: 0.35rem; color: #374151; }

    /* ---------- "Gestione sito" button at the bottom of the sidebar (teal, like "Gestione studio") ---------- */
    .gest-site-button-wrap { padding: 0.75rem 1rem 1rem; }
    .gest-site-button { display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; background: #0d9488; color: #fff; border-radius: 0.375rem; padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: 500; box-shadow: 0 1px 2px #0000000d; }
    .gest-site-button:hover { background: #0f766e; }
    .gest-site-button:focus-visible { outline: 2px solid #14b8a6; outline-offset: 2px; }

    /* ---------- Shared bits ---------- */
    .gest-color-dot { display: inline-block; width: 0.625rem; height: 0.625rem; border-radius: 9999px; margin-right: 0.5rem; vertical-align: middle; }
    .gest-color-option { display: block; margin: -0.25rem -0.5rem; padding: 0.25rem 0.5rem; border-radius: 0.25rem; color: #111827; }
    /* Chosen colour: just the swatch */
    .fi-select-input-value-label .gest-color-option { font-size: 0; height: 1.25rem; min-width: 2.5rem; margin: 0; padding: 0; }

    /* ---------- Calendar page ---------- */
    .gest-calendar { display: flex; flex-direction: column; gap: 0.75rem; height: calc(100dvh - 6rem); }
    .gest-calendar-toolbar { display: grid; grid-template-columns: 1fr auto 1fr; align-items: center; gap: 1rem; }
    .gest-calendar-toolbar-right { justify-content: flex-end; }
    @media (max-width: 80rem) { .gest-calendar-toolbar { grid-template-columns: 1fr; } .gest-calendar-title { text-align: left; } .gest-calendar-toolbar-right { justify-content: flex-start; } }
    .gest-calendar-toolbar-left, .gest-calendar-toolbar-right { display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; }
    .gest-calendar-title { font-size: 1.5rem; font-weight: 700; color: #111827; text-align: center; white-space: nowrap; }
    .gest-btn-dark { background: #1f2937; color: #fff; border-radius: 0.5rem; padding: 0.45rem 0.9rem; font-size: 0.875rem; font-weight: 600; letter-spacing: 0.03em; }
    .gest-btn-dark:hover { background: #111827; }
    .gest-icon-btn { display: inline-flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 0.5rem; color: #374151; }
    .gest-icon-btn:hover { background: #e5e7eb; }
    .gest-icon { width: 1.25rem; height: 1.25rem; }
    .gest-select { max-width: 13rem; border: 1px solid #d1d5db; border-radius: 0.5rem; padding: 0.4rem 2rem 0.4rem 0.75rem; font-size: 0.875rem; background-color: #fff; }
    .gest-check { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.875rem; color: #374151; }
    .gest-calendar-body { flex: 1; min-height: 32rem; background: #fff; border-radius: var(--radius-xl); box-shadow: 0 1px 3px #0000001a; overflow: hidden; }
    .gest-calendar-body > div { height: 100%; }

    .gest-calendar .fc { --fc-border-color: #e5e7eb; --fc-today-bg-color: #fefbe8; --fc-now-indicator-color: #dc2626; font-size: 0.85rem; }
    .gest-calendar .fc .fc-col-header-cell-cushion { color: #374151; font-weight: 600; padding: 0.5rem; text-transform: none; }
    .gest-calendar .fc .fc-timegrid-slot { height: 1.1rem; }
    .gest-calendar .fc .fc-timegrid-slot-minor { border-top-style: dotted; }
    .gest-calendar .fc .fc-timegrid-slot-label-cushion, .gest-calendar .fc .fc-timegrid-axis-cushion { color: #6b7280; }
    .gest-calendar .fc .fc-event { border-radius: 0.375rem; padding: 1px 3px; cursor: pointer; }
    .gest-calendar .fc .fc-event .fc-event-main { color: #111827; }
    .gest-calendar .fc .gest-event-cancelled { opacity: 0.55; text-decoration: line-through; }
    .gest-calendar .fc .gest-event-completed { opacity: 0.8; }
    .gest-calendar .fc .gest-event-no_show { background-image: repeating-linear-gradient(45deg, transparent 0 6px, rgb(255 255 255 / .45) 6px 12px); }
    .gest-calendar .fc .fc-highlight { background: rgb(79 70 229 / .12); }
    .gest-calendar .fc-list-day-cushion { background: #f3f4f6; }

    /* ---------- "Nuovo evento" modal: dark header ---------- */
    .fi-modal-window.gest-event-modal > .fi-modal-header { background-color: #1f2937; }
    .fi-modal-window.gest-event-modal .fi-modal-footer { border-top: 1px solid #e5e7eb; background: #f9fafb; padding-top: 1rem; border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl); }
    .fi-modal-window.gest-event-modal .fi-modal-footer-actions { flex-direction: row-reverse; justify-content: space-between; width: 100%; }
    .fi-modal-window.gest-event-modal .fi-sc-tabs { box-shadow: none; --tw-ring-shadow: 0 0 #0000; }
    .fi-modal-window.gest-event-modal .fi-section-header-heading { color: #6b7280; }

    .gest-calendar-chip { display: flex; align-items: center; background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.45rem 0.75rem; min-height: 2.25rem; }
    .gest-recurring-box { border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.5rem 0.75rem; margin-top: 1.75rem; white-space: nowrap; }

    /* Titolo: menu with the services of the price list */
    .gest-title-input { position: relative; }
    .gest-title-suggestions { position: absolute; z-index: 50; left: 0; right: 0; top: calc(100% + 0.35rem); background: #fff; border: 1px solid #e5e7eb; border-radius: 0.75rem; box-shadow: 0 10px 25px -5px #0000002a; padding: 0.35rem 0; max-height: 16rem; overflow-y: auto; }
    .gest-title-suggestion { display: flex; align-items: baseline; gap: 0.5rem; width: 100%; padding: 0.55rem 1rem; text-align: left; font-size: 0.95rem; color: #111827; }
    .gest-title-suggestion:hover, .gest-title-suggestion:focus-visible { background: #f3f4f6; outline: none; }
    .gest-title-suggestion-price { color: #6b7280; }
    .gest-title-suggestion-duration { color: #6b7280; font-size: 0.8rem; }

    /* "Trova disponibilità" side panel */
    .gest-availability-panel { background: #f9fafb; border-left: 1px solid #e5e7eb; margin: -1.5rem -1.5rem -1.5rem 0; padding: 1rem; align-self: stretch; }
    .gest-availability-panel .fi-section { background: transparent; box-shadow: none; --tw-ring-shadow: 0 0 #0000; }
    .gest-slots { display: flex; flex-direction: column; gap: 0.9rem; }
    .gest-slots-total { text-align: right; font-size: 0.8rem; color: #6b7280; }
    .gest-slots-professional { font-weight: 700; color: #111827; border-bottom: 1px solid #e5e7eb; padding-bottom: 0.25rem; }
    .gest-slots-day-header { display: flex; justify-content: space-between; align-items: center; font-weight: 600; font-size: 0.875rem; color: #111827; margin-bottom: 0.4rem; }
    .gest-slots-day-header > span:first-child { display: inline-flex; align-items: center; gap: 0.4rem; }
    .gest-slots-day-icon { width: 1rem; height: 1rem; color: var(--gest-accent); }
    .gest-slots-day-count { font-weight: 400; font-size: 0.8rem; color: #6b7280; }
    .gest-slots-grid { display: flex; flex-wrap: wrap; gap: 0.4rem; }
    .gest-slot { border: 1px solid #d1d5db; background: #fff; border-radius: 0.4rem; padding: 0.3rem 0.6rem; font-size: 0.85rem; color: #111827; }
    .gest-slot:hover { border-color: var(--gest-accent); color: var(--gest-accent); }
    .gest-slot-selected { background: #eef2ff; border-color: var(--gest-accent); color: var(--gest-accent); font-weight: 600; }
    .gest-slots-empty { font-size: 0.85rem; color: #6b7280; }
</style>
