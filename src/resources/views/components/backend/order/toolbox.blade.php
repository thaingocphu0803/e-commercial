@props([
    'model',
    'object'
])

<div class="ibox-tools">
    <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li>
            <a
                href="#"
                class="changeStatusAllOrder"
                data-value="paid"
                data-field="payment"
                data-model="{{$model}}"
            >
                 {{__('custom.paymentCompleteAttrChoosen', ['attribute' => __('custom.'. $object) ])}}
            </a>
        </li>
        <li>
            <a
                href="#"
                class="changeStatusAllOrder"
                data-value="unpaid"
                data-field="payment"
                data-model="{{$model}}"
            >
            {{__('custom.unpaidAttrChoosen', ['attribute' => __('custom.'. $object) ])}}
            </a>
        </li>
                <li>
            <a
                href="#"
                class="changeStatusAllOrder"
                data-value="pending"
                data-field="delivery"
                data-model="{{$model}}"
            >
            {{__('custom.pendingDeliveryAttrChoosen', ['attribute' => __('custom.'. $object) ])}}
            </a>
        </li>
                <li>
            <a
                href="#"
                class="changeStatusAllOrder"
                data-value="delivering"
                data-field="delivery"
                data-model="{{$model}}"
            >
            {{__('custom.inDeliveryAttrChoosen', ['attribute' => __('custom.'. $object) ])}}
            </a>
        </li>
        <li>
            <a
                href="#"
                class="changeStatusAllOrder"
                data-value="success"
                data-field="delivery"
                data-model="{{$model}}"
            >
            {{__('custom.deliveredAttrChoosen', ['attribute' => __('custom.'. $object) ])}}
            </a>
        </li>
    </ul>
    <a class="close-link">
        <i class="fa fa-times"></i>
    </a>
</div>
