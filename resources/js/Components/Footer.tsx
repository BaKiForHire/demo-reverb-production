import React from 'react';
import { Box, Flex } from '@chakra-ui/react';
import { FaFacebook, FaTwitter, FaInstagram } from 'react-icons/fa';
import ApplicationLogo from './ApplicationLogo';

const Footer: React.FC = () => {
    return (
        <footer className="mt-12">
            <Box bg="#141414" color="white" py={10}>
                <Flex direction="column" align="center">
                <ApplicationLogo className="mb-6" />

                    {/* Main Footer Content */}
                    <div className="w-full max-w-6xl flex flex-col md:flex-row justify-between px-4">
                        {/* Firearms & Ammo Sections */}
                        <div className="flex flex-wrap items-start gap-12 w-full max-w-md mt-8 md:mt-0 self-center">
                            <div className="flex flex-col items-start">
                                <div className="font-bold mb-2 text-xl uppercase" style={{ letterSpacing: '0.2em' }}>Firearms</div>
                                <div className="text-md uppercase my-2">Handguns</div>
                                <div className="text-md uppercase my-2">Rifles</div>
                                <div className="text-md uppercase my-2">Shotguns</div>
                                <div className="text-md uppercase my-2">DMRs</div>
                                <div className="text-md uppercase my-2">AR Rifles</div>
                                <div className="text-md uppercase my-2">SLRs</div>
                                <div className="text-md uppercase my-2">Snipers</div>
                            </div>
                            <div className="flex flex-col items-start">
                                <div className="font-bold mb-2 text-xl uppercase" style={{ letterSpacing: '0.2em' }}>Ammo</div>
                                <div className="text-md uppercase my-2">Handgun Ammo</div>
                                <div className="text-md uppercase my-2">9mm Ammo</div>
                                <div className="text-md uppercase my-2">.45 ACP Ammo</div>
                                <div className="text-md uppercase my-2">.40 S&W Ammo</div>
                                <div className="text-md uppercase my-2">Rifle Ammo</div>
                                <div className="text-md uppercase my-2">5.56 NATO Ammo</div>
                                <div className="text-md uppercase my-2">7.62 NATO Ammo</div>
                                <div className="text-md uppercase my-2">.308 Win Ammo</div>
                                <div className="text-md uppercase my-2">Shotgun Ammo</div>
                                <div className="text-md uppercase my-2">12 Gauge Ammo</div>
                                <div className="text-md uppercase my-2">20 Gauge Ammo</div>
                            </div>
                        </div>

                        {/* Newsletter & Social Media */}
                        <div className="flex flex-col items-start w-full max-w-md mt-8 md:mt-0 self-center">
                            <div className="font-bold mb-2 uppercase">Subscribe to our newsletter</div>
                            <div className="font-bold mb-2">Join our newsletter to stay up to date with what is currently happening at New Frontier Armory</div>
                            <div className="flex gap-4 w-full">
                                <input
                                    type="email"
                                    placeholder="Enter your email"
                                    className="bg-white flex-grow text-black w-full p-2 max-w-full"
                                />
                                <button className="bg-[#78866b] text-white px-12 py-2">Subscribe</button>
                            </div>
                            <div className="flex mt-4">
                                <button aria-label="Facebook" className="bg-[#78866b] text-white mr-2 p-4">
                                    <FaFacebook size={18} />
                                </button>
                                <button aria-label="Twitter" className="bg-[#78866b] text-white mr-2 p-4">
                                    <FaTwitter size={18} />
                                </button>
                                <button aria-label="Instagram" className="bg-[#78866b] text-white p-4">
                                    <FaInstagram size={18} />
                                </button>
                            </div>
                        </div>
                    </div>
                </Flex>

                {/* Footer Bottom Text */}
                <Flex justify="center" mt={10}>
                    <div className="text-center uppercase opacity-50">© BigBoreBids 2024. All rights reserved.</div>
                </Flex>
            </Box>
        </footer>
    );
};

export default Footer;
