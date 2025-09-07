const emojiButton = document.getElementById('emoji-button');
const emojiPopup = document.getElementById('emoji-popup');
const tabs = document.querySelectorAll('.tab');
const grids = document.querySelectorAll('.emoji-grid');
const emojis = document.querySelectorAll('.emoji');
const msginput = document.getElementById('msg');

tabs[0].classList.add('active');
grids[0].classList.add('active');

tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        grids.forEach(g => g.classList.remove('active'));
        tab.classList.add('active');
        grids[index].classList.add('active');
    });
});

emojiButton.addEventListener('click', (e) => {
    emojiPopup.style.display = emojiPopup.style.display === 'block' ? 'none' : 'block';
    e.stopPropagation();
});

document.addEventListener('click', (e) => {
    if (!emojiPopup.contains(e.target) && e.target !== emojiButton)
        emojiPopup.style.display = 'none';
});

emojis.forEach(emoji => {
    emoji.addEventListener('click', () => {
        msginput.value += emoji.textContent;
        emojiPopup.style.display = 'none';
        msginput.focus();
    });
});
