<template>
    <td class="w-full lg:w-auto flex justify-between p-3 text-gray-800 text-left border-b lg:table-cell relative lg:static">
        <span class="lg:hidden px-2 py-1 text-xs font-bold uppercase">
            <slot name="header" />
        </span>

        <slot />
    </td>
</template>
