import React from 'react';

interface BBBHandgunProps {
    size?: number;
    color?: string;
}

const BBBHandgun: React.FC<BBBHandgunProps> = ({ size = 24, color = 'currentColor' }) => {
    return (
        <svg 
            width={40} 
            height={size} 
            viewBox="0 0 40 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M39.4457 2.07534C39.3206 1.65811 39.2371 1.42169 38.7782 1.49123C38.4305 1.54686 38.3053 1.40777 38.3331 1.06008C38.3609 0.837561 38.2775 0.57332 38.0132 0.656765C37.6099 0.768026 37.1371 0.879282 36.9145 1.24088C36.7616 1.50513 36.6086 1.51904 36.3861 1.50513C35.4403 1.42168 34.5085 1.56076 33.5628 1.53295C30.3918 1.46341 27.2209 1.50513 24.0639 1.50513C20.9068 1.50513 19.669 1.50513 17.4716 1.50513C17.2908 1.50513 16.9988 1.6303 17.0127 1.2687C17.0266 0.865376 16.7623 0.921007 16.5259 0.921007C14.398 0.921007 12.2841 0.89319 10.1562 0.921007C9.18264 0.934914 8.27864 0.893196 7.52763 0.169996C7.34683 -0.0108032 7.09649 -0.0386219 6.88788 0.0448246C6.67926 0.128271 6.79052 0.378611 6.80443 0.55941C6.80443 0.879286 6.80443 1.04618 6.37329 1.074C5.85871 1.10181 5.39976 1.46341 5.26068 1.90846C5.05207 2.61775 4.63483 2.58993 4.09243 2.46476C3.88382 2.42304 3.67521 2.39522 3.4805 2.36741C3.28579 2.33959 3.07718 2.32568 2.96591 2.50648C2.85465 2.70119 2.92419 2.92372 3.07717 3.09061C3.68911 3.75818 3.77256 4.56482 3.74474 5.4271C3.71693 6.26155 3.43877 6.53971 2.63213 6.60925C1.76985 6.67879 0.96321 6.95694 0.253919 7.44371C0.114842 7.54106 -0.0242353 7.65232 0.00358008 7.86094C0.0453031 8.09737 0.240009 8.13909 0.434717 8.16691C0.643332 8.19472 0.851947 8.20863 1.06056 8.20863C1.83939 8.20863 2.61822 8.19472 3.39705 8.22253C4.42622 8.27816 5.05206 8.8901 5.24677 9.89145C5.38585 10.6286 5.33022 11.3657 5.16333 12.0889C4.76 13.869 4.05071 15.5519 3.09108 17.0956C2.28444 18.4029 2.2149 19.8076 2.24271 21.254C2.24271 21.4209 2.22881 21.6852 2.3957 21.6991C2.85465 21.7408 2.7573 22.0468 2.74339 22.2971C2.72948 22.8395 2.96591 23.0481 3.50831 23.0064C3.75865 22.9786 4.2037 22.8951 4.25933 23.062C4.41231 23.5349 4.7461 23.3402 4.98253 23.3402C7.2912 23.3541 9.61378 23.3402 11.9225 23.3402C12.8404 23.3402 12.9377 23.2011 12.7291 22.2971C12.7152 22.2276 12.6874 22.158 12.6596 22.0885C12.2701 21.2262 12.2701 20.3639 12.4927 19.446C12.9099 17.6937 13.2298 15.9274 13.6053 14.175C13.8278 13.1598 14.5371 12.7008 15.5663 12.8816C15.7749 12.9233 15.9835 12.9233 16.1921 12.9233C17.5412 12.9233 18.8902 12.9233 20.2253 12.9233C20.8836 12.9233 21.1201 12.6174 20.9346 12.0054C20.2949 10.0027 21.1989 8.38943 23.2294 7.90266C23.8831 7.74967 24.5367 7.68014 25.2043 7.69404C27.0262 7.69404 28.8481 7.69404 30.67 7.69404C32.4919 7.69404 34.6893 7.69404 36.692 7.69404C37.2344 7.69404 37.749 7.49934 38.3053 7.51324C38.6252 7.51324 38.8338 7.249 38.8755 6.95694C39.1259 5.34365 40.002 3.82771 39.4875 2.08925L39.4457 2.07534ZM20.1002 11.7134C20.1002 12.1862 19.516 12.1584 19.516 12.1584H18.2087C18.0557 12.1584 17.8888 12.1584 17.7359 12.1584C17.4299 12.1584 17.11 12.1584 16.804 12.1584C16.5815 12.1584 16.3729 12.1584 16.1504 12.1028C15.8027 12.0332 15.4272 11.922 15.1351 11.7134C15.0795 11.6716 15.01 11.6299 14.9543 11.5882C14.8013 11.4769 14.6623 11.3518 14.5371 11.1988C13.9113 10.406 14.7457 9.50204 14.7457 9.50204C14.8431 9.4325 14.9821 9.36296 15.0795 9.46032C15.149 9.52986 15.149 9.6133 15.1351 9.71066C15.1212 9.80801 15.0795 9.91927 15.0795 10.0166C15.0795 10.0166 15.0795 10.0444 15.0795 10.0583C15.0656 10.2391 15.0795 10.4339 15.0795 10.6147C15.0795 10.7537 15.1351 10.8789 15.2047 10.9902C15.2464 11.0458 15.2881 11.1014 15.3298 11.1571C15.3576 11.1849 15.3994 11.2266 15.4272 11.2544C15.455 11.2822 15.4828 11.2961 15.5106 11.3239C15.5524 11.3518 15.5941 11.3796 15.6358 11.4074C15.7053 11.4491 15.7888 11.4908 15.8583 11.5326C15.9418 11.5743 16.0252 11.616 16.1226 11.6438C16.1504 11.6438 16.1643 11.6577 16.1921 11.6716C16.2617 11.6994 16.3312 11.7134 16.4007 11.7134C16.4424 11.7134 16.4981 11.7134 16.5537 11.7134C16.5954 11.6995 16.6093 11.6716 16.6093 11.6299C16.6093 11.6021 16.6093 11.5743 16.6093 11.5604C16.5537 11.3935 16.4424 11.2683 16.3312 11.1431C16.2199 11.018 16.1365 10.865 16.053 10.712C15.9835 10.559 15.9279 10.406 15.8861 10.2531C15.8444 10.1001 15.8027 9.91927 15.8027 9.73847C15.8027 9.55767 15.8305 9.44641 15.9001 9.32124C16.2756 8.52851 17.1378 8.59804 17.1378 8.59804H19.0849C19.0849 8.59804 19.0849 8.61195 19.0849 8.62586C19.0154 9.04309 19.224 9.29342 19.4743 9.4325C19.5995 9.51595 19.7525 9.57158 19.9194 9.58548C19.9194 9.58548 19.9472 9.58548 19.9611 9.58548C20.0167 9.66893 20.0584 9.76629 20.0724 9.87755C20.1002 10.0444 20.1141 10.2113 20.1141 10.3921C20.1141 10.5034 20.1141 10.6147 20.1141 10.7259C20.1141 11.1292 20.1141 11.5326 20.1141 11.7273L20.1002 11.7134Z" fill="#78866B" />
        </svg>
    );
};

export default BBBHandgun;