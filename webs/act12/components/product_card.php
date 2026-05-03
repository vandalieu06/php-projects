<?php
function renderProductCard($product)
{
  ?>
    <div class="group relative flex flex-col mb-12 break-inside-avoid">
        <div class="relative overflow-hidden bg-[#f4f4f4] aspect-[3/4]">
            <img
                src="<?php
                $tipus = $product["tipusImatge"];
                $imatge = base64_encode($product["dadesImatge"]);
                echo "data:$tipus;base64,$imatge";
                ?>"
                alt="<?= $product["nom"] ?>"
                class="object-cover w-full h-full transition-transform duration-700 ease-out group-hover:scale-105"
            />

            <div class="absolute inset-0 flex items-end p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-500 bg-gradient-to-t from-black/20 to-transparent">
                <form method="POST" class="w-full">
                    <input type="hidden" name="product_id" value="<?= $product[
                      "codiProducte"
                    ] ?>">
                    <button
                        type="submit"
                        name="add_to_cart"
                        class="w-full bg-white text-black py-4 px-6 text-xs tracking-widest uppercase font-medium hover:bg-black hover:text-white transition-colors duration-300 shadow-xl"
                    >
                        Añadir a la Cesta
                    </button>
                </form>
            </div>
        </div>

        <div class="mt-6 flex justify-between items-start">
            <div>
                <h3 class="text-lg font-light tracking-tight text-neutral-900 leading-tight">
                    <?= $product["nom"] ?>
                </h3>
                <p class="text-xs text-neutral-400 mt-1 uppercase tracking-[0.2em] font-medium">
                    <?= $product["descripcio"] ?>
                </p>
            </div>
            <span class="text-sm font-medium text-neutral-800">
                <?= number_format($product["preu"], 2) ?>€
            </span>
        </div>
    </div>
    <?php
}
