@props(['message'])

<x-message.panel>

    <table class="min-w-full divide-y divide-gray-300 dark:divide-neutral-800">
        <tbody class="divide-y divide-gray-200 bg-white dark:divide-neutral-800 dark:bg-neutral-900">

            @foreach ($message->parsed->getAllHeaders() as $header)
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 dark:text-neutral-200">{{ $header->getName() }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-neutral-300">{{ $header->getValue() }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

</x-message.panel>
