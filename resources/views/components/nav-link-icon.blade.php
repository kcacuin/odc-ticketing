@props(['active'])
{{-- @props(['name']) --}}
@php
// $classes = ($active ?? false)
//             ? 'fill-red w-6'
//             : 'fw-6';
@endphp

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="dashboard" viewBox="0 0 38 35">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.22222 12.2499C3.10242 12.2499 2.02848 11.8812 1.23666 11.2248C0.44484 10.5684 0 9.6782 0 8.74994V3.49994C0 2.57168 0.44484 1.68144 1.23666 1.02507C2.02848 0.368688 3.10242 -6.10352e-05 4.22222 -6.10352e-05H12.6667C13.7865 -6.10352e-05 14.8604 0.368688 15.6522 1.02507C16.444 1.68144 16.8889 2.57168 16.8889 3.49994V8.74994C16.8889 9.6782 16.444 10.5684 15.6522 11.2248C14.8604 11.8812 13.7865 12.2499 12.6667 12.2499H4.22222ZM4.22222 8.74994H12.6667V3.49994H4.22222V8.74994ZM4.22222 34.9999C3.10242 34.9999 2.02848 34.6312 1.23666 33.9748C0.44484 33.3184 0 32.4282 0 31.4999V17.4999C0 16.5717 0.44484 15.6814 1.23666 15.0251C2.02848 14.3687 3.10242 13.9999 4.22222 13.9999H12.6667C13.7865 13.9999 14.8604 14.3687 15.6522 15.0251C16.444 15.6814 16.8889 16.5717 16.8889 17.4999V31.4999C16.8889 32.4282 16.444 33.3184 15.6522 33.9748C14.8604 34.6312 13.7865 34.9999 12.6667 34.9999H4.22222ZM4.22222 31.4999H12.6667V17.4999H4.22222V31.4999ZM21.1111 31.4999C21.1111 32.4282 21.556 33.3184 22.3478 33.9748C23.1396 34.6312 24.2135 34.9999 25.3333 34.9999H33.7778C34.8976 34.9999 35.9715 34.6312 36.7633 33.9748C37.5552 33.3184 38 32.4282 38 31.4999V27.9999C38 27.0717 37.5552 26.1814 36.7633 25.5251C35.9715 24.8687 34.8976 24.4999 33.7778 24.4999H25.3333C24.2135 24.4999 23.1396 24.8687 22.3478 25.5251C21.556 26.1814 21.1111 27.0717 21.1111 27.9999V31.4999ZM33.7778 31.4999H25.3333V27.9999H33.7778V31.4999ZM25.3333 20.9999C24.2135 20.9999 23.1396 20.6312 22.3478 19.9748C21.556 19.3184 21.1111 18.4282 21.1111 17.4999V3.49994C21.1111 2.57168 21.556 1.68144 22.3478 1.02507C23.1396 0.368688 24.2135 -6.10352e-05 25.3333 -6.10352e-05H33.7778C34.8976 -6.10352e-05 35.9715 0.368688 36.7633 1.02507C37.5552 1.68144 38 2.57168 38 3.49994V17.4999C38 18.4282 37.5552 19.3184 36.7633 19.9748C35.9715 20.6312 34.8976 20.9999 33.7778 20.9999H25.3333ZM25.3333 17.4999H33.7778V3.49994H25.3333V17.4999Z" fill="#F0EFEF"/>
    </symbol>
    <symbol id="clients" viewBox="0 0 40 33">
        <path d="M39.4627 19.1675C39.3227 19.2855 39.1633 19.3714 38.9937 19.4202C38.8241 19.469 38.6476 19.4798 38.4743 19.452C38.301 19.4242 38.1342 19.3583 37.9836 19.2581C37.8329 19.1579 37.7013 19.0254 37.5963 18.868C36.7927 17.6547 35.7468 16.6703 34.5427 15.994C33.3386 15.3177 32.0099 14.9684 30.6637 14.9743C30.4015 14.9743 30.1452 14.8874 29.9268 14.7246C29.7083 14.5618 29.5374 14.3302 29.4355 14.0589C29.3663 13.8746 29.3307 13.6767 29.3307 13.4767C29.3307 13.2767 29.3663 13.0788 29.4355 12.8945C29.5374 12.6232 29.7083 12.3916 29.9268 12.2288C30.1452 12.066 30.4015 11.9791 30.6637 11.9791C31.4117 11.979 32.1448 11.7433 32.7795 11.2987C33.4143 10.8541 33.9253 10.2185 34.2546 9.46398C34.5839 8.70949 34.7182 7.86638 34.6423 7.03044C34.5664 6.19449 34.2833 5.39921 33.8252 4.73493C33.3671 4.07065 32.7523 3.564 32.0507 3.27252C31.3491 2.98105 30.5888 2.91643 29.8562 3.08601C29.1236 3.25559 28.4479 3.65257 27.9061 4.23187C27.3642 4.81116 26.9778 5.54954 26.7908 6.36314C26.747 6.55366 26.6703 6.73263 26.565 6.88984C26.4596 7.04704 26.3277 7.1794 26.1769 7.27935C26.026 7.3793 25.8591 7.44489 25.6856 7.47238C25.5122 7.49986 25.3356 7.4887 25.166 7.43954C24.9964 7.39037 24.8371 7.30416 24.6971 7.18583C24.5572 7.06749 24.4394 6.91935 24.3504 6.74987C24.2614 6.58039 24.203 6.39287 24.1785 6.19804C24.1541 6.00321 24.164 5.80487 24.2078 5.61435C24.4673 4.48613 24.9577 3.44153 25.6399 2.56367C26.3221 1.6858 27.1773 0.998911 28.1374 0.557641C29.0975 0.116372 30.1361 -0.0670943 31.1704 0.0218411C32.2047 0.110776 33.2063 0.469659 34.0955 1.06993C34.9846 1.67021 35.7367 2.4953 36.292 3.47957C36.8474 4.46383 37.1905 5.5801 37.2942 6.73956C37.3979 7.89901 37.2592 9.06965 36.8893 10.1583C36.5193 11.247 35.9283 12.2236 35.1632 13.0106C36.976 13.8923 38.5519 15.2914 39.7344 17.069C39.8394 17.2268 39.9157 17.4062 39.9589 17.5971C40.0021 17.7881 40.0114 17.9867 39.9861 18.1816C39.9609 18.3765 39.9017 18.564 39.8119 18.7331C39.722 18.9023 39.6034 19.0499 39.4627 19.1675ZM30.4837 30.699C30.5802 30.8694 30.645 31.06 30.6741 31.2593C30.7033 31.4587 30.6963 31.6625 30.6535 31.8587C30.6108 32.0549 30.5331 32.2393 30.4252 32.4009C30.3174 32.5625 30.1815 32.6979 30.0258 32.799C29.8702 32.9001 29.6979 32.9647 29.5194 32.9891C29.3409 33.0134 29.1599 32.997 28.9872 32.9407C28.8145 32.8844 28.6537 32.7895 28.5146 32.6616C28.3754 32.5337 28.2607 32.3755 28.1773 32.1966C27.3375 30.5992 26.1414 29.2753 24.7071 28.3556C23.2728 27.436 21.6498 26.9523 19.9982 26.9523C18.3467 26.9523 16.7237 27.436 15.2894 28.3556C13.8551 29.2753 12.659 30.5992 11.8192 32.1966C11.7358 32.3755 11.6211 32.5337 11.4819 32.6616C11.3428 32.7895 11.182 32.8844 11.0093 32.9407C10.8366 32.997 10.6556 33.0134 10.4771 32.9891C10.2986 32.9647 10.1263 32.9001 9.97068 32.799C9.81501 32.6979 9.67915 32.5625 9.57127 32.4009C9.4634 32.2393 9.38573 32.0549 9.34296 31.8587C9.30018 31.6625 9.29317 31.4587 9.32235 31.2593C9.35153 31.06 9.4163 30.8694 9.51277 30.699C10.8053 28.2043 12.7761 26.2412 15.1355 25.098C13.8078 23.9562 12.8321 22.3757 12.3454 20.5787C11.8588 18.7817 11.8857 16.8586 12.4223 15.0797C12.9589 13.3008 13.9783 11.7555 15.3372 10.661C16.6961 9.56653 18.3262 8.97793 19.9982 8.97793C21.6703 8.97793 23.3004 9.56653 24.6593 10.661C26.0182 11.7555 27.0376 13.3008 27.5742 15.0797C28.1108 16.8586 28.1377 18.7817 27.6511 20.5787C27.1644 22.3757 26.1887 23.9562 24.861 25.098C27.2204 26.2412 29.1912 28.2043 30.4837 30.699ZM19.9982 23.9598C21.053 23.9598 22.084 23.6085 22.961 22.9503C23.8379 22.292 24.5214 21.3565 24.9251 20.2619C25.3287 19.1673 25.4343 17.9628 25.2285 16.8008C25.0228 15.6388 24.5149 14.5714 23.7691 13.7336C23.0233 12.8959 22.0731 12.3253 21.0386 12.0942C20.0042 11.8631 18.9319 11.9817 17.9575 12.4351C16.9831 12.8885 16.1502 13.6563 15.5642 14.6414C14.9783 15.6265 14.6655 16.7847 14.6655 17.9695C14.6655 19.5582 15.2274 21.0819 16.2274 22.2053C17.2275 23.3287 18.5839 23.9598 19.9982 23.9598ZM10.666 13.4767C10.666 13.0795 10.5255 12.6986 10.2755 12.4177C10.0255 12.1369 9.68637 11.9791 9.33279 11.9791C8.58475 11.979 7.85173 11.7433 7.21697 11.2987C6.58222 10.8541 6.07118 10.2185 5.74191 9.46398C5.41264 8.70949 5.27833 7.86638 5.35423 7.03044C5.43014 6.19449 5.71322 5.39921 6.17132 4.73493C6.62942 4.07065 7.24418 3.564 7.94577 3.27252C8.64736 2.98105 9.40766 2.91643 10.1403 3.08601C10.8729 3.25559 11.5486 3.65257 12.0904 4.23187C12.6323 4.81116 13.0187 5.54954 13.2057 6.36314C13.2941 6.74792 13.5149 7.07749 13.8196 7.27935C14.1243 7.48121 14.488 7.53883 14.8305 7.43954C15.173 7.34024 15.4664 7.09216 15.6461 6.74987C15.8258 6.40758 15.8771 5.99912 15.7887 5.61435C15.5292 4.48613 15.0388 3.44153 14.3566 2.56367C13.6744 1.6858 12.8192 0.998911 11.8591 0.557641C10.899 0.116372 9.86044 -0.0670943 8.82611 0.0218411C7.79177 0.110776 6.79019 0.469659 5.90105 1.06993C5.01191 1.67021 4.25977 2.4953 3.70446 3.47957C3.14914 4.46383 2.806 5.5801 2.70232 6.73956C2.59863 7.89901 2.73728 9.06965 3.10723 10.1583C3.47717 11.247 4.0682 12.2236 4.83329 13.0106C3.0223 13.8931 1.4482 15.2922 0.267142 17.069C0.054772 17.3868 -0.0365323 17.7863 0.0133155 18.1797C0.0631633 18.573 0.25008 18.928 0.532946 19.1666C0.815811 19.4052 1.17146 19.5077 1.52164 19.4517C1.87182 19.3957 2.18786 19.1858 2.40023 18.868C3.20379 17.6547 4.24972 16.6703 5.45382 15.994C6.65793 15.3177 7.98657 14.9684 9.33279 14.9743C9.68637 14.9743 10.0255 14.8165 10.2755 14.5357C10.5255 14.2548 10.666 13.8739 10.666 13.4767Z" fill="#F0EFEF"/>
    </symbol>
    <symbol id="messages" viewBox="0 0 34 29">
        <path d="M30.3333 2H3.66667C2.74619 2 2 2.79949 2 3.78571V25.2143C2 26.2005 2.74619 27 3.66667 27H30.3333C31.2538 27 32 26.2005 32 25.2143V3.78571C32 2.79949 31.2538 2 30.3333 2Z" stroke="#F0EFEF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M30.3337 2.89294L17.0003 16.2858L3.66699 2.89294" stroke="#F0EFEF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="appointments" viewBox="0 0 37 37">
        <path d="M31.4989 5.30005H5.68736C3.65089 5.30005 2 6.77751 2 8.60004V31.7C2 33.5225 3.65089 35 5.68736 35H31.4989C33.5354 35 35.1863 33.5225 35.1863 31.7V8.60004C35.1863 6.77751 33.5354 5.30005 31.4989 5.30005Z" stroke="#F0EFEF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M25.968 2V8.59999" stroke="#F0EFEF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M11.2185 2V8.59999" stroke="#F0EFEF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M2 15.2001H35.1863" stroke="#F0EFEF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    </symbol>
    <symbol id="projects" viewBox="0 0 40 37">
        <path d="M40 0.625H0V11.875H2V32.5C2 34.5719 3.79 36.25 6 36.25H34C36.21 36.25 38 34.5719 38 32.5V11.875H40V0.625ZM4 4.375H36V8.125H4V4.375ZM34 32.5H6V11.875H34V32.5ZM14 15.625H26C26 17.6969 24.21 19.375 22 19.375H18C15.79 19.375 14 17.6969 14 15.625Z" fill="#F0EFEF"/>
    </symbol>
    <symbol id="settings" viewBox="0 0 42 40">
        <path d="M21.0001 11C19.2201 11 17.48 11.5278 16 12.5168C14.5199 13.5057 13.3664 14.9113 12.6852 16.5558C12.004 18.2004 11.8258 20.01 12.173 21.7558C12.5203 23.5016 13.3775 25.1053 14.6362 26.364C15.8948 27.6226 17.4985 28.4798 19.2443 28.8271C20.9901 29.1743 22.7997 28.9961 24.4443 28.3149C26.0888 27.6337 27.4944 26.4802 28.4833 25.0001C29.4723 23.5201 30.0001 21.78 30.0001 20C29.9976 17.6138 29.0486 15.3261 27.3613 13.6388C25.674 11.9515 23.3863 11.0025 21.0001 11ZM21.0001 26C19.8134 26 18.6534 25.6481 17.6667 24.9888C16.68 24.3295 15.911 23.3925 15.4568 22.2961C15.0027 21.1997 14.8839 19.9933 15.1154 18.8295C15.3469 17.6656 15.9184 16.5965 16.7575 15.7574C17.5966 14.9182 18.6657 14.3468 19.8296 14.1153C20.9935 13.8838 22.1999 14.0026 23.2962 14.4567C24.3926 14.9108 25.3296 15.6799 25.9889 16.6666C26.6482 17.6533 27.0001 18.8133 27.0001 20C27.0001 21.5913 26.368 23.1174 25.2428 24.2426C24.1175 25.3679 22.5914 26 21.0001 26ZM41.6139 16.1019C41.5721 15.8906 41.4853 15.6909 41.3595 15.5162C41.2336 15.3415 41.0716 15.1959 40.8845 15.0894L35.2914 11.9019L35.2689 5.59812C35.2682 5.38102 35.2204 5.16666 35.1288 4.96984C35.0372 4.77301 34.9039 4.59842 34.7382 4.45812C32.7094 2.74193 30.3729 1.42675 27.8532 0.582499C27.6548 0.515336 27.4445 0.490481 27.2359 0.509534C27.0273 0.528587 26.825 0.591126 26.642 0.693124L21.0001 3.84687L15.3526 0.687498C15.1695 0.584927 14.967 0.521915 14.758 0.502537C14.549 0.483158 14.3383 0.507844 14.1395 0.574998C11.6216 1.42542 9.28791 2.74562 7.26199 4.46562C7.09655 4.60572 6.96345 4.78001 6.87185 4.97649C6.78024 5.17297 6.73231 5.38697 6.73136 5.60375L6.70324 11.9131L1.11011 15.1006C0.922991 15.2072 0.760996 15.3527 0.635141 15.5274C0.509285 15.7021 0.422518 15.9019 0.380738 16.1131C-0.131144 18.6854 -0.131144 21.3333 0.380738 23.9056C0.422518 24.1169 0.509285 24.3166 0.635141 24.4913C0.760996 24.666 0.922991 24.8116 1.11011 24.9181L6.70324 28.1056L6.72574 34.4094C6.72642 34.6265 6.77421 34.8408 6.86583 35.0377C6.95744 35.2345 7.09069 35.4091 7.25636 35.5494C9.28525 37.2656 11.6217 38.5808 14.1414 39.425C14.3398 39.4922 14.5501 39.517 14.7587 39.498C14.9673 39.4789 15.1696 39.4164 15.3526 39.3144L21.0001 36.1531L26.6476 39.3125C26.8711 39.437 27.123 39.5016 27.3789 39.5C27.5427 39.4999 27.7054 39.4733 27.8607 39.4212C30.3783 38.572 32.712 37.253 34.7382 35.5344C34.9037 35.3943 35.0368 35.22 35.1284 35.0235C35.22 34.827 35.2679 34.613 35.2689 34.3962L35.297 28.0869L40.8901 24.8994C41.0772 24.7928 41.2392 24.6473 41.3651 24.4726C41.4909 24.2979 41.5777 24.0981 41.6195 23.8869C42.1285 21.3166 42.1266 18.6714 41.6139 16.1019ZM38.8014 22.6475L33.4445 25.6944C33.2098 25.8278 33.0154 26.0222 32.882 26.2569C32.7732 26.4444 32.6589 26.6431 32.5426 26.8306C32.3938 27.0671 32.3145 27.3406 32.3139 27.62L32.2857 33.6669C30.8459 34.7976 29.2418 35.7018 27.5289 36.3481L22.1251 33.3369C21.9008 33.2127 21.6484 33.1482 21.392 33.1494H21.3564C21.1295 33.1494 20.9007 33.1494 20.6739 33.1494C20.4055 33.1427 20.1402 33.2074 19.9051 33.3369L14.4976 36.3556C12.7811 35.7142 11.1725 34.8145 9.72761 33.6875L9.70699 27.65C9.70606 27.3701 9.62683 27.096 9.47824 26.8587C9.36199 26.6712 9.24761 26.4837 9.14074 26.285C9.00822 26.0467 8.8139 25.8485 8.57824 25.7113L3.21574 22.6569C2.93824 20.9015 2.93824 19.1135 3.21574 17.3581L8.56324 14.3056C8.79795 14.1722 8.99228 13.9778 9.12574 13.7431C9.23449 13.5556 9.34886 13.3569 9.46511 13.1694C9.61392 12.9329 9.69319 12.6594 9.69386 12.38L9.72199 6.33312C11.1619 5.2024 12.766 4.29822 14.4789 3.65187L19.8751 6.66312C20.11 6.7933 20.3755 6.85806 20.6439 6.85062C20.8707 6.85062 21.0995 6.85062 21.3264 6.85062C21.5947 6.85733 21.86 6.79262 22.0951 6.66312L27.5026 3.64437C29.2192 4.28576 30.8277 5.18551 32.2726 6.3125L32.2932 12.35C32.2942 12.6299 32.3734 12.904 32.522 13.1412C32.6382 13.3287 32.7526 13.5162 32.8595 13.715C32.992 13.9533 33.1863 14.1515 33.422 14.2887L38.7845 17.3431C39.0657 19.0998 39.0689 20.8898 38.7939 22.6475H38.8014Z" fill="#F0EFEF"/>
    </symbol>
    <symbol id="admin" viewBox="0 0 40 46">
        <g clip-path="url(#clip0_3_760)">
        <path d="M22.5 14.375C22.5 13.9938 22.6317 13.6281 22.8661 13.3585C23.1005 13.089 23.4185 12.9375 23.75 12.9375H38.75C39.0815 12.9375 39.3994 13.089 39.6339 13.3585C39.8683 13.6281 40 13.9938 40 14.375C40 14.7563 39.8683 15.1219 39.6339 15.3915C39.3994 15.6611 39.0815 15.8125 38.75 15.8125H23.75C23.4185 15.8125 23.1005 15.6611 22.8661 15.3915C22.6317 15.1219 22.5 14.7563 22.5 14.375ZM38.75 21.5625H23.75C23.4185 21.5625 23.1005 21.714 22.8661 21.9835C22.6317 22.2531 22.5 22.6188 22.5 23C22.5 23.3813 22.6317 23.7469 22.8661 24.0165C23.1005 24.2861 23.4185 24.4375 23.75 24.4375H38.75C39.0815 24.4375 39.3994 24.2861 39.6339 24.0165C39.8683 23.7469 40 23.3813 40 23C40 22.6188 39.8683 22.2531 39.6339 21.9835C39.3994 21.714 39.0815 21.5625 38.75 21.5625ZM38.75 30.1875H27.5C27.1685 30.1875 26.8505 30.339 26.6161 30.6085C26.3817 30.8781 26.25 31.2438 26.25 31.625C26.25 32.0063 26.3817 32.3719 26.6161 32.6415C26.8505 32.9111 27.1685 33.0625 27.5 33.0625H38.75C39.0815 33.0625 39.3994 32.9111 39.6339 32.6415C39.8683 32.3719 40 32.0063 40 31.625C40 31.2438 39.8683 30.8781 39.6339 30.6085C39.3994 30.339 39.0815 30.1875 38.75 30.1875ZM23.7109 34.1406C23.7518 34.3235 23.7609 34.5138 23.7378 34.7008C23.7147 34.8877 23.6598 35.0676 23.5762 35.2301C23.4926 35.3926 23.382 35.5346 23.2507 35.648C23.1194 35.7614 22.97 35.8439 22.8109 35.8908C22.709 35.9224 22.6039 35.9381 22.4984 35.9375C22.2212 35.9377 21.9518 35.8318 21.7326 35.6367C21.5134 35.4415 21.3568 35.1681 21.2875 34.8594C20.325 30.5577 16.5469 27.3125 12.4984 27.3125C8.44998 27.3125 4.67185 30.5559 3.70935 34.8594C3.62647 35.2287 3.41941 35.5451 3.13371 35.7388C2.84801 35.9326 2.50708 35.9879 2.18592 35.8926C1.86476 35.7973 1.58967 35.5591 1.42118 35.2306C1.25269 34.902 1.2046 34.51 1.28748 34.1406C2.16092 30.2396 4.69998 27.0807 7.92185 25.5156C6.68128 24.4168 5.7709 22.8989 5.31839 21.175C4.86588 19.451 4.89395 17.6074 5.39864 15.9027C5.90334 14.198 6.85936 12.7177 8.13262 11.6695C9.40587 10.6212 10.9325 10.0575 12.4984 10.0575C14.0643 10.0575 15.591 10.6212 16.8642 11.6695C18.1375 12.7177 19.0935 14.198 19.5982 15.9027C20.1029 17.6074 20.131 19.451 19.6784 21.175C19.2259 22.8989 18.3156 24.4168 17.075 25.5156C20.2984 27.0807 22.8375 30.2396 23.7109 34.1406ZM12.5 24.4375C13.4889 24.4375 14.4556 24.1003 15.2778 23.4685C16.1001 22.8366 16.7409 21.9386 17.1194 20.8879C17.4978 19.8373 17.5968 18.6811 17.4039 17.5657C17.211 16.4503 16.7348 15.4258 16.0355 14.6216C15.3363 13.8175 14.4453 13.2699 13.4754 13.048C12.5055 12.8261 11.5002 12.94 10.5866 13.3752C9.67293 13.8104 8.89204 14.5474 8.34263 15.493C7.79322 16.4386 7.49998 17.5503 7.49998 18.6875C7.49998 20.2125 8.02676 21.675 8.96444 22.7534C9.90213 23.8317 11.1739 24.4375 12.5 24.4375Z" fill="#F0EFEF"/>
        </g>
        <defs>
        <clipPath id="clip0_3_760">
        <rect width="40" height="46" fill="white"/>
        </clipPath>
        </defs>
    </symbol>
</svg>

{{-- * The actual navlink component --}}
    {{-- <svg {{ $attributes->merge(['class' => 'icon']) }}>
        <use xlink:href="#{{ $name }}" />
    </svg> --}}
<span class="max-w-0 translate-x-8 text-sm transition-opacity duration-300 group-hover:visible group-hover:opacity-100">
    {{ $slot }}
</span>
