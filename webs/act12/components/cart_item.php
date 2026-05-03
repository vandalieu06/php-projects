<?php
// components/cart_item.php
function renderCartItem($product, $quantity)
{
  ?>
    <div class="flex items-center justify-between py-8 border-b border-neutral-200 group">
        <div class="flex items-center gap-8">
            <div class="w-24 h-32 overflow-hidden bg-neutral-100 flex-shrink-0">
                <img
                    src="<?php
                    $tipus = $product["tipusImatge"];
                    $imatge = base64_encode($product["dadesImatge"]);
                    echo "data:$tipus;base64,$imatge";
                    ?>"
                    alt="<?= $product["nom"] ?>"
                    class="w-24 object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                />
            </div>

            <div class="flex flex-col">
                <span class="text-[10px] uppercase tracking-[0.2em] text-neutral-400 mb-1">
                    <?= $product["descripcio"] ?>
                </span>
                <h3 class="serif text-xl font-light tracking-tight text-neutral-900">
                    <?= $product["nom"] ?>
                </h3>
                <div class="mt-4 flex items-center gap-4 text-[11px] font-medium tracking-widest uppercase">
                    <span class="text-neutral-400">Cant:</span>
                    <span class="bg-neutral-100 px-2 py-1"><?= $quantity ?></span>
                </div>
            </div>
        </div>

        <div class="text-right">
            <p class="text-lg font-light tracking-tighter">
                <?= number_format($product["preu"] * $quantity, 2) ?>€
            </p>
            <?php if ($quantity > 1): ?>
                <p class="text-[10px] text-neutral-400 mt-1">
                    <?= number_format($product["preu"], 2) ?>€ c/u
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
