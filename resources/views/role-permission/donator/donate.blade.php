@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Donate Products</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('donate') }}" method="POST">
                @csrf
                <div id="donation-items">
                    <div class="row donation-item mb-3">
                        <div class="col-md-4">
                            <label for="product_name">Product Name:</label>
                            <input type="text" name="items[0][product_name]" required class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="items[0][quantity]" min="1" required class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="price">Price:</label>
                            <input type="number" step="0.01" name="items[0][price]" min="0" required class="form-control">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" onclick="removeDonationItem(this)" class="btn btn-danger w-100">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addDonationItem()">Add Another Item</button>
                <button type="submit" class="btn btn-success">Donate</button>
            </form>
        </div>
    </div>
</div>

<script>
    let itemIndex = 1;

    function addDonationItem() {
        const donationItems = document.getElementById('donation-items');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'donation-item', 'mb-3');
        newItem.innerHTML = `
            <div class="col-md-4">
                <label for="product_name">Product Name:</label>
                <input type="text" name="items[${itemIndex}][product_name]" required class="form-control">
            </div>
            <div class="col-md-3">
                <label for="quantity">Quantity:</label>
                <input type="number" name="items[${itemIndex}][quantity]" min="1" required class="form-control">
            </div>
            <div class="col-md-3">
                <label for="price">Price:</label>
                <input type="number" step="0.01" name="items[${itemIndex}][price]" min="0" required class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" onclick="removeDonationItem(this)" class="btn btn-danger w-100">Remove</button>
            </div>
        `;
        donationItems.appendChild(newItem);
        itemIndex++;
    }

    function removeDonationItem(button) {
        const donationItem = button.parentElement.parentElement;
        donationItem.remove();
    }
</script>
@endsection
