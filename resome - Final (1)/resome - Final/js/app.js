// Select2 call
$(document).ready(function () {
    $('.select2').select2();
});
// Select2 call

// Range Slider Configure
function updateInputsFromSlider(data) {
    $(".js-input-from").val(data.from);
    $(".js-input-to").val(data.to);
}

$(".js-range-slider").ionRangeSlider({
    skin: "big",
    type: "double",
    grid: false,
    min: 1,
    max: 1000000,
    from: 0,
    to: 1000000,
    onStart: updateInputsFromSlider,
    onChange: updateInputsFromSlider,
    onFinish: updateInputsFromSlider,
    onUpdate: updateInputsFromSlider
});

$(".js-input-from, .js-input-to").on("input", function () {
    var from = parseInt($(".js-input-from").val()) || 0;
    var to = parseInt($(".js-input-to").val()) || 0;

    if (from > to) {
        [from, to] = [to, from];
    }

    $(".js-range-slider").data("ionRangeSlider").update({ from: from, to: to });
});
// Range Slider Configure

// Filter & Search
document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#submitFilter').addEventListener('click', () => {
        // Get selected options from all selects
        const selectedStudyFields = getSelectedOptions('#studyField');
        const selectedUniversities = getSelectedOptions('#university');
        const selectedProvinces = getSelectedOptions('#province');
        const selectedCities = getSelectedOptions('#city');
        const selectedStudyPeriods = getSelectedOptions('#studyPeriod');

        // Get input values from the form
        const inputName = document.querySelector('#name').value;
        const inputGender = document.querySelector('#gender').value;
        const inputRankFrom = parseInt(document.querySelector('.js-input-from').value);
        const inputRankTo = parseInt(document.querySelector('.js-input-to').value);

        // Hide all cards and the "notFound" card
        const cards = Array.from(document.querySelectorAll('.card:not(.notFound)'));
        const notFoundCard = document.querySelector('.notFound');
        const showMore = document.querySelector('#showMore');
        cards.forEach(card => card.classList.add('hidden'));
        notFoundCard.classList.add('hidden');
        showMore.classList.remove('hidden');  // Make sure "showMore" is visible at the start

        // Show only cards with matching attributes
        cards.forEach(card => {
            const cardName = card.querySelector('[data-person-name]').textContent;
            const cardFamily = card.querySelector('[data-person-family]').textContent;
            const cardGender = card.querySelector('[data-person-gender]').textContent;
            const cardRank = parseInt(card.querySelector('[data-person-rank]').textContent);

            if ((cardName.startsWith(inputName) || cardFamily.startsWith(inputName)) &&
                (inputGender === 'همه' || cardGender === inputGender) &&
                (isNaN(inputRankFrom) || cardRank >= inputRankFrom) &&
                (isNaN(inputRankTo) || cardRank <= inputRankTo) &&
                matchesSelectedOptions(card, 'studyField', selectedStudyFields) &&
                matchesSelectedOptions(card, 'university', selectedUniversities) &&
                matchesSelectedOptions(card, 'province', selectedProvinces) &&
                matchesSelectedOptions(card, 'city', selectedCities) &&
                matchesSelectedOptions(card, 'studyPeriod', selectedStudyPeriods)) {
                card.classList.remove('hidden');
            }
        });

        // If no cards are visible, show the "notFound" card and hide "showMore"
        const visibleCards = cards.filter(card => !card.classList.contains('hidden'));
        if (visibleCards.length === 0) {
            notFoundCard.classList.remove('hidden');
            showMore.classList.add('hidden');  // Hide "showMore" when "notFound" is shown
        }
    });
});

const getSelectedOptions = selectId => Array.from(document.querySelectorAll(`${selectId} .select2-selection__choice__display`)).map(option => option.textContent.trim());

const matchesSelectedOptions = (card, attribute, selectedOptions) => {
    const element = card.querySelector(`[data-person-${attribute}]`);
    if (!element) return false;  // If the element doesn't exist, return false
    const value = element.textContent.trim();
    return selectedOptions.length === 0 || selectedOptions.includes(value);
}
// Filter & Search

// Modal

// ابتدا یک آبجکت برای اطلاعات کاربران ایجاد می‌کنیم
let userInfo = {
    1: {src: "videos/video1.mp4"},
    2: {src: "videos/video2.mp4"},
    3: {src: "videos/video3.mp4"},
    4: {src: "videos/video4.mp4"},
};

// تمام دکمه‌ها را پیدا می‌کنیم
let buttons = document.querySelectorAll('.btn');

// برای هر دکمه یک تابع رویداد کلیک اضافه می‌کنیم
buttons.forEach((button) => {
    button.addEventListener('click', (event) => {
        // id کارت را از ویژگی data-id دریافت می‌کنیم
        let id = event.target.closest('.card').querySelector('.id-number').dataset.id;

        // متن دکمه را دریافت می‌کنیم
        let buttonText = event.target.innerText;

        // نام کامل کاربر را از داده‌های کارت دریافت می‌کنیم
        let fullName = event.target.closest('.card').querySelector('[data-person-fullName]').innerText;

        // متن کامل را می‌سازیم
        let fullText = `${buttonText} - ${fullName}`;

        // متن کامل را در عنوان مودال قرار می‌دهیم
        document.querySelector('.modal-title').innerText = fullText;

        // سورس ویدیو را بر اساس id کارت تغییر می‌دهیم
        document.querySelector('video source').src = userInfo[id].src;

        // ویدیو را دوباره بارگذاری می‌کنیم تا تغییرات اعمال شود
        document.querySelector('video').load();
    });
});

