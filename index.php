<?php // index.php ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Christmas Wishlist</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="container">
    <h1>🎄 Christmas Wishlist</h1>

    <div class="form">
      <input id="itemInput" placeholder="Add something you wish for..." />
      <button id="addBtn">Add</button>
    </div>

    <div id="message" class="message"></div>

    <ul id="list"></ul>
  </div>

<script>
const api = 'api.php';
const listEl = document.getElementById('list');
const msgEl = document.getElementById('message');

async function loadList() {
  const res = await fetch(api);
  const data = await res.json();
  if (!data.ok) return;
  listEl.innerHTML = '';
  data.items.forEach(it => {
    const li = document.createElement('li');
    li.textContent = it.item + ' — ' + new Date(it.created_at).toLocaleString();
    listEl.appendChild(li);
  });
}

async function addItem() {
  const input = document.getElementById('itemInput');
  const value = input.value.trim();
  if (!value) return showMessage('Please enter an item');
  const res = await fetch(api, {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({item: value})
  });
  const data = await res.json();
  if (data.ok) {
    input.value = '';
    loadList();
    showMessage('Added to wishlist!');
  } else {
    showMessage('Error: ' + (data.error || 'Unknown'));
  }
}

function showMessage(t) {
  msgEl.textContent = t;
  setTimeout(()=>msgEl.textContent = '', 3000);
}

document.getElementById('addBtn').addEventListener('click', addItem);
window.addEventListener('load', loadList);
</script>
</body>
</html>