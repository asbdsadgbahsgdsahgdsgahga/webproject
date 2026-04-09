const coffees = [
    { name: "Classic Espresso", price: 3.00, img: "https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&q=80&w=400" },
    { name: "Americano", price: 3.50, img: "https://images.unsplash.com/photo-1559525839-b184a4d698c7?auto=format&fit=crop&q=80&w=400" },
    { name: "Cappuccino", price: 4.50, img: "https://images.unsplash.com/photo-1534778101976-62847782c213?auto=format&fit=crop&q=80&w=400" },
    { name: "Café Latte", price: 4.50, img: "https://images.unsplash.com/photo-1570968915860-54d5c301fa9f?auto=format&fit=crop&q=80&w=400" },
    { name: "Mocha", price: 5.00, img: "https://images.unsplash.com/photo-1596078841242-12f73dc697c6?auto=format&fit=crop&q=80&w=400" },
    { name: "Caramel Macchiato", price: 4.75, img: "https://images.unsplash.com/photo-1485808191679-5f86510681a2?auto=format&fit=crop&q=80&w=400" },
    { name: "Flat White", price: 4.50, img: "https://images.unsplash.com/photo-1588195538326-c5b1e9f80a1b?auto=format&fit=crop&q=80&w=400" },
    { name: "Cortado", price: 4.00, img: "https://images.unsplash.com/photo-1512568400610-62da28bc8a13?auto=format&fit=crop&q=80&w=400" },
    { name: "Cold Brew", price: 4.50, img: "https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&q=80&w=400" },
    { name: "Nitro Cold Brew", price: 5.50, img: "https://images.unsplash.com/photo-1558562805-4bf1e2a724eb?auto=format&fit=crop&q=80&w=400" },
    { name: "Affogato", price: 6.00, img: "https://images.unsplash.com/photo-1551024709-8f23befc6f87?auto=format&fit=crop&q=80&w=400" },
    { name: "Irish Coffee", price: 7.00, img: "https://images.unsplash.com/photo-1541167760496-1628856ab772?auto=format&fit=crop&q=80&w=400" }
];

const menuGrid = document.querySelector('.menu-grid');
const modal = document.getElementById('orderModal');
let currentPrice = 0;

function renderMenuItems(items) {
    menuGrid.innerHTML = '';

    if (items.length === 0) {
        const message = document.createElement('p');
        message.className = 'no-results';
        message.innerText = 'No items available at the moment.';
        menuGrid.appendChild(message);
        return;
    }

    items.forEach(coffee => {
        const item = document.createElement('div');
        item.className = 'menu-item';
        item.innerHTML = `
            <img src="${coffee.img}" alt="${coffee.name}">
            <h3>${coffee.name}</h3>
            <p class="price">$${coffee.price.toFixed(2)}</p>
            <button type="button" onclick="openModal('${coffee.name}', ${coffee.price})">Order Now</button>
        `;
        menuGrid.appendChild(item);
    });
}

renderMenuItems(coffees);

function openModal(name, price) {
    currentPrice = price;
    document.getElementById('coffee_name').value = name;
    document.getElementById('unit_price').value = price;
    document.getElementById('modal_coffee_title').innerText = name;
    document.getElementById('modal_coffee_price').innerText = price.toFixed(2);
    document.getElementById('quantity').value = 1;
    updateTotal();
    modal.style.display = 'flex';
}

function closeModal() {
    modal.style.display = 'none';
}

function updateTotal() {
    const qty = document.getElementById('quantity').value;
    const total = currentPrice * qty;
    document.getElementById('modal_total_price').innerText = total.toFixed(2);
}
