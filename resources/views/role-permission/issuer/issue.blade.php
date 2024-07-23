<!-- resources/views/role-permission/issuer/issue.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h4>Issue Goods</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('issue.store') }}" method="POST">
                @csrf
                <div id="issue-items">
                    <div class="row issue-item mb-3">
                        <div class="col-md-5">
                            <label for="product">Product:</label>
                            <select name="items[0][product_id]" required class="form-control">
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="quantity">Quantity:</label>
                            <input type="number" name="items[0][quantity]" min="1" required class="form-control">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" onclick="removeIssueItem(this)" class="btn btn-danger w-100">Remove</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="addIssueItem()">Add Another Item</button>
                <button type="submit" class="btn btn-success">Issue</button>
            </form>
        </div>
    </div>
</div>

<script>
    let itemIndex = 1;

    function addIssueItem() {
        const issueItems = document.getElementById('issue-items');
        if (issueItems.children.length >= 3) {
            Swal.fire({
                icon: 'error',
                title: 'Limit Exceeded',
                text: 'You cannot add more than 3 items per entry.',
            });
            return;
        }
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'issue-item', 'mb-3');
        newItem.innerHTML = `
            <div class="col-md-5">
                <label for="product">Product:</label>
                <select name="items[${itemIndex}][product_id]" required class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="quantity">Quantity:</label>
                <input type="number" name="items[${itemIndex}][quantity]" min="1" required class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" onclick="removeIssueItem(this)" class="btn btn-danger w-100">Remove</button>
            </div>
        `;
        issueItems.appendChild(newItem);
        itemIndex++;
    }

    function removeIssueItem(button) {
        const issueItem = button.parentElement.parentElement;
        issueItem.remove();
    }
</script>
@endsection
