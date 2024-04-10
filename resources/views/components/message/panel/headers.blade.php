@props([
    'message'
])

<x-message.panel>

    <table class="min-w-full divide-y divide-gray-300">
        <tbody class="bg-white divide-y divide-gray-200">

            @foreach($message->parsed->getAllHeaders() as $header)
                <tr>
                    <td class="py-4 pl-4 pr-3 text-sm font-medium text-gray-900 whitespace-nowrap sm:pl-6">{{ $header->getName() }}</td>
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $header->getValue() }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

</x-message.panel>
