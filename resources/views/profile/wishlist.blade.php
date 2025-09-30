@extends('layouts.app')
@section('title', 'SJL')
@section('content')
<main class="profile-page">
    <div class="container py-5">
        <div class="row">
            <!-- Sidebar -->
            @include('profile.profilecommon')

            <!-- Content Area -->
            <div class="col-lg-9 col-md-12">
                <div class="pofile-content-card">
                    <div id="wishlist" class="content-section">
                        <table id="wishlist-table"
                            class="display order-list-table table table-striped table-hover table-bordered align-middle table-responsive nowrap">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($favorites)): ?>
                                    <?php foreach ($favorites as $order):

                                    ?>
                                        <tr>
                                            <td>
                                                <img width="50" height="50"
                                                    src="<?= htmlspecialchars($order['image_url']) ?>"
                                                    onclick="zoomImage('<?= htmlspecialchars($order['image_url']) ?>')"
                                                    style="cursor: pointer;">

                                            </td>

                                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                                            <td class="primary-view">
                                                <a class="common-primary-btn"  href="{{ route('ext.product', ['category' => $order['prefix'], 'slug' => $order['slug']]) }}" class="block">
                                                    <i class="fa fa-eye"></i>
                                                </a>    
                                         
                                                <a href="javascript:void(0);" 
                                                class="common-primary-btn unfav-btn" 
                                                data-id="{{ $order->id }}">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No favorite orders found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
<script>

</script>